<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
    public ?string $resetUrl = null;

    /**
     * Gera o token de recuperação e registra o link no log, sem enviar email.
     */
    public function requestLink(array $data): string
    {
        $this->resetUrl = null;

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return Password::INVALID_USER;
        }

        if ($this->recentlyCreatedToken($user)) {
            return Password::RESET_THROTTLED;
        }

        $token = $this->generateToken();

        DB::table($this->tokenTable())->updateOrInsert(
            ['email' => $user->getEmailForPasswordReset()],
            ['token' => $this->hashToken($token), 'created_at' => now()]
        );

        $this->resetUrl = route('user.password.reset', ['token' => $token]);

        Log::info('Link de recuperação de senha gerado.', [
            'url' => $this->resetUrl,
        ]);

        return Password::RESET_LINK_SENT;
    }

    /**
     * Busca na tabela o registro de um token válido e retorna o email dono dele.
     */
    public function findEmailByToken(string $token): ?string
    {
        return $this->findTokenRecord($token)?->email;
    }

    /**
     * Valida o token e atualiza a senha do usuário.
     */
    public function reset(array $data): string
    {
        $record = $this->findTokenRecord($data['token']);

        if (! $record) {
            throw new Exception("Código inválido.");
        }

        $user = User::where('email', $record->email)->first();

        if (! $user) {
            throw new Exception("Usuário não encontrado.");
        }

        $user->update(["password"=>Hash::make($data['password'])]);

        DB::table($this->tokenTable())->where('email', $record->email)->delete();

        return 1;
    }

    private function findTokenRecord(string $token): ?object
    {
        $record = DB::table($this->tokenTable())
            ->where('token', $token)
            ->first();

        if (! $record || $this->tokenExpired($record->created_at)) {
            return null;
        }

        return $record;
    }

    private function generateToken(): string
    {
        return 'rp_'.Str::uuid().Str::uuid();
    }

    private function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    private function recentlyCreatedToken(User $user): bool
    {
        $throttle = (int) $this->brokerConfig('throttle', 60);

        if ($throttle <= 0) {
            return false;
        }

        $record = DB::table($this->tokenTable())
            ->where('email', $user->getEmailForPasswordReset())
            ->first();

        return $record && Carbon::parse($record->created_at)->addSeconds($throttle)->isFuture();
    }

    private function tokenExpired(string $createdAt): bool
    {
        $expire = (int) $this->brokerConfig('expire', 60);

        return Carbon::parse($createdAt)->addMinutes($expire)->isPast();
    }

    private function brokerConfig(string $key, mixed $default = null): mixed
    {
        $broker = config('auth.defaults.passwords', 'users');

        return config("auth.passwords.{$broker}.{$key}", $default);
    }

    private function tokenTable(): string
    {
        return "password_reset_tokens";
    }
}
