<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('redireciona visitantes para o login', function () {
    $this->get(route('admin.index'))->assertRedirect(route('user.login'));
});

it('bloqueia usuários comuns', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.index'))
        ->assertRedirect(route('user.index'));
});

it('permite ao admin acessar o dashboard e a listagem', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.index'))
        ->assertOk()
        ->assertSee('Painel administrativo');

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Usuários');
});

it('permite ao admin criar um usuário', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Novo Usuário',
            'email' => 'novo@example.com',
            'role' => 'user',
            'password' => 'SenhaForte1!',
            'password_confirmation' => 'SenhaForte1!',
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'novo@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Novo Usuário')
        ->and($user->role)->toBe('user')
        ->and(Hash::check('SenhaForte1!', $user->password))->toBeTrue();
});

it('atualiza o usuário mantendo a senha quando o campo fica vazio', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $originalPassword = $user->password;

    $this->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            'role' => 'admin',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('admin.users.index'));

    $user->refresh();

    expect($user->name)->toBe('Nome Atualizado')
        ->and($user->role)->toBe('admin')
        ->and($user->password)->toBe($originalPassword);
});

it('impede o admin de excluir a própria conta', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $admin))
        ->assertSessionHas('error');

    expect($admin->fresh()->trashed())->toBeFalse();
});

it('exclui, lista e restaura usuários', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect();

    $this->assertSoftDeleted($user);

    $this->actingAs($admin)
        ->get(route('admin.users.index', ['status' => 'trashed']))
        ->assertOk()
        ->assertSee($user->email);

    $this->actingAs($admin)
        ->patch(route('admin.users.restore', $user))
        ->assertRedirect();

    expect($user->fresh()->trashed())->toBeFalse();
});

it('exclui permanentemente um usuário da lixeira', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $user->delete();

    $this->actingAs($admin)
        ->delete(route('admin.users.force-delete', $user))
        ->assertRedirect();

    expect(User::withTrashed()->find($user->id))->toBeNull();
});
