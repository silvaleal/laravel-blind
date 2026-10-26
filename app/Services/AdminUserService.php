<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class AdminUserService
{
    public function __construct(
        protected User $userModel
    ) {}

    /**
     * @return array<string, int>
     */
    public function dashboardStats(): array
    {
        return [
            'total' => $this->userModel->newQuery()->count(),
            'admins' => $this->userModel->newQuery()->where('role', 'admin')->count(),
            'users' => $this->userModel->newQuery()->where('role', 'user')->count(),
            'trashed' => $this->userModel->onlyTrashed()->count(),
            'new_this_month' => $this->userModel->newQuery()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
        ];
    }

    public function recentUsers(int $limit = 5): Collection
    {
        return $this->userModel->newQuery()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->userModel->newQuery();

        $status = $filters['status'] ?? 'active';

        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        $query->when($filters['search'] ?? null, function ($query, string $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        });

        $query->when(
            $filters['role'] ?? null,
            fn ($query, string $role) => $query->where('role', $role)
        );

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
    {
        return $this->userModel->newQuery()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $data['password'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return $user->refresh();
    }

    public function delete(User $user): void
    {
        $this->ensureNotCurrentUser($user, 'Você não pode excluir a própria conta por aqui.');

        $user->delete();
    }

    public function restore(User $user): void
    {
        $user->restore();
    }

    public function forceDelete(User $user): void
    {
        $this->ensureNotCurrentUser($user, 'Você não pode excluir a própria conta por aqui.');

        $user->forceDelete();
    }

    private function ensureNotCurrentUser(User $user, string $message): void
    {
        if ($user->is(auth()->user())) {
            throw new RuntimeException($message);
        }
    }
}
