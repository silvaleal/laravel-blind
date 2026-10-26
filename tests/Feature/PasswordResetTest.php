<?php

use App\Models\User;
use App\Services\PasswordResetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

function createResetToken(User $user): string
{
    $service = app(PasswordResetService::class);
    $service->requestLink(['email' => $user->email]);

    return basename(parse_url($service->resetUrl, PHP_URL_PATH));
}

it('gera o token e registra o link no log sem enviar email', function () {
    Notification::fake();

    $url = null;

    Log::spy();
    Log::shouldReceive('info')->andReturnUsing(function ($message, $context) use (&$url) {
        $url = $context['url'] ?? null;
    });

    $user = User::factory()->create();

    $this->post(route('user.auth.recover-password.store'), ['email' => $user->email])
        ->assertRedirect()
        ->assertSessionHas('status')
        ->assertSessionHas('reset_url');

    Notification::assertNothingSent();

    expect($url)->not->toBeNull()
        ->and($url)->not->toContain('email=');

    $token = basename(parse_url($url, PHP_URL_PATH));

    expect($token)->toStartWith('rp_')
        ->and(strlen($token))->toBe(75)
        ->and(Str::isUuid(substr($token, 3, 36)))->toBeTrue()
        ->and(Str::isUuid(substr($token, 39, 36)))->toBeTrue();

    $storedToken = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');

    expect($storedToken)->toBe(hash('sha256', $token));
});

it('não revela quando o email não está cadastrado', function () {
    $this->post(route('user.auth.recover-password.store'), ['email' => 'nao-existe@example.com'])
        ->assertRedirect()
        ->assertSessionHas('status')
        ->assertSessionMissing('reset_url');
});

it('respeita o throttle ao solicitar novo link', function () {
    $user = User::factory()->create();

    $this->post(route('user.auth.recover-password.store'), ['email' => $user->email])
        ->assertSessionHas('status');

    $this->post(route('user.auth.recover-password.store'), ['email' => $user->email])
        ->assertSessionHasErrors('email');
});

it('exibe a página de reset apenas com o token e mostra o email afetado', function () {
    $user = User::factory()->create();
    $token = createResetToken($user);

    $this->get(route('user.password.reset', ['token' => $token]))
        ->assertOk()
        ->assertSee($user->email);
});

it('ignora registros de token que não correspondem ao código', function () {
    $other = User::factory()->create();

    DB::table('password_reset_tokens')->insert([
        'email' => $other->email,
        'token' => hash('sha256', 'outro-token'),
        'created_at' => now(),
    ]);

    $user = User::factory()->create();
    $token = createResetToken($user);

    $this->get(route('user.password.reset', ['token' => $token]))
        ->assertOk()
        ->assertSee($user->email);
});

it('não exibe a página de reset com token inválido', function () {
    $this->get(route('user.password.reset', ['token' => 'token-invalido']))
        ->assertRedirect(route('user.auth.recover-password'))
        ->assertSessionHasErrors('email');
});

it('não exibe a página de reset com token expirado', function () {
    $user = User::factory()->create();
    $token = 'token-expirado';

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $token),
        'created_at' => now()->subMinutes(61),
    ]);

    $this->get(route('user.password.reset', ['token' => $token]))
        ->assertRedirect(route('user.auth.recover-password'))
        ->assertSessionHasErrors('email');
});

it('recusa o hash armazenado no banco como código de reset', function () {
    $user = User::factory()->create();
    $storedHash = hash('sha256', 'algum-token');

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => $storedHash,
        'created_at' => now(),
    ]);

    $this->get(route('user.password.reset', ['token' => $storedHash]))
        ->assertRedirect(route('user.auth.recover-password'))
        ->assertSessionHasErrors('email');
});

it('redefine a senha com um token válido', function () {
    $user = User::factory()->create();
    $token = createResetToken($user);

    $this->post(route('user.password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'NewPassword1!',
        'password_confirmation' => 'NewPassword1!',
    ])
        ->assertRedirect(route('user.login'))
        ->assertSessionHas('success');

    expect(Hash::check('NewPassword1!', $user->fresh()->password))->toBeTrue();
    expect(DB::table('password_reset_tokens')->where('email', $user->email)->exists())->toBeFalse();
});

it('recusa token inválido', function () {
    $user = User::factory()->create();

    $this->post(route('user.password.update'), [
        'token' => 'token-invalido',
        'email' => $user->email,
        'password' => 'NewPassword1!',
        'password_confirmation' => 'NewPassword1!',
    ])->assertSessionHasErrors('email');

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});

it('recusa token expirado', function () {
    $user = User::factory()->create();
    $token = 'token-expirado';

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $token),
        'created_at' => now()->subMinutes(61),
    ]);

    $this->post(route('user.password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'NewPassword1!',
        'password_confirmation' => 'NewPassword1!',
    ])->assertSessionHasErrors('email');

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});

it('abre a página de reset a partir do link gerado', function () {
    $user = User::factory()->create();
    $url = null;

    Log::spy();
    Log::shouldReceive('info')->andReturnUsing(function ($message, $context) use (&$url) {
        $url = $context['url'] ?? null;
    });

    $this->post(route('user.auth.recover-password.store'), ['email' => $user->email])
        ->assertSessionHas('status');

    expect($url)->not->toBeNull();

    $this->get(parse_url($url, PHP_URL_PATH))
        ->assertOk()
        ->assertSee($user->email);
});
