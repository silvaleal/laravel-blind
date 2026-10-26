<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\AdminUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class AdminUserController extends Controller
{
    public function __construct(
        protected AdminUserService $adminUserService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'role', 'status']);

        return view('admin.users.index', [
            'users' => $this->adminUserService->paginate($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->adminUserService->create($request->validated());

        return to_route('admin.users.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if ($user->is(auth()->user()) && $data['role'] !== 'admin') {
            return back()
                ->withInput()
                ->withErrors(['role' => 'Você não pode remover seu próprio acesso de administrador.']);
        }

        $this->adminUserService->update($user, $data);

        return to_route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->adminUserService->delete($user);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Usuário excluído com sucesso.');
    }

    public function restore(User $user): RedirectResponse
    {
        $this->adminUserService->restore($user);

        return back()->with('success', 'Usuário restaurado com sucesso.');
    }

    public function forceDelete(User $user): RedirectResponse
    {
        try {
            $this->adminUserService->forceDelete($user);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Usuário excluído permanentemente.');
    }
}
