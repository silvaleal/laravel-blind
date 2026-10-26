<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Password;

class RecoverPasswordController extends Controller
{
    public function __construct(
        protected PasswordResetService $passwordResetService
    ) {}

    public function index()
    {
        return view('user.auth.recover-password');
    }

    public function store(RecoverPasswordRequest $request)
    {
        $status = $this->passwordResetService->requestLink($request->validated());




        // if ($this->passwordResetService->resetUrl && ! app()->environment('production')) {
        //     session()->flash('reset_url', $this->passwordResetService->resetUrl);
        // }

        return back()->with(
            'status',
            'Se o email estiver cadastrado, enviaremos as instruções de recuperação.'
        );
    }

    public function reset(string $token)
    {
        $email = $this->passwordResetService->findEmailByToken($token);

        if (! $email) {
            return to_route('user.auth.recover-password')->withErrors([
                'email' => 'Este link de recuperação é inválido, expirou ou foi substituído por uma nova solicitação.',
            ]);
        }

        return view('user.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function update(ResetPasswordRequest $request)
    {
        $status = $this->passwordResetService->reset($request->validated());

        if ($status === Password::PASSWORD_RESET) {
            return to_route('user.login')->with('success', 'Senha redefinida com sucesso.');
        }

        $message = match ($status) {
            Password::INVALID_TOKEN => 'Este link de recuperação é inválido ou expirou.',
            Password::INVALID_USER => 'Não encontramos uma conta com este email.',
            default => 'Não foi possível redefinir a senha.',
        };

        return back()->withErrors(['email' => $message])->withInput($request->only('email'));
    }
}
