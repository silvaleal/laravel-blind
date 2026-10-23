<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Exception;
use Hash;

class UserSecurityService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected User $userModel
    ) {
    }

    public function updateAccount(array $data)
    {
        $this->userModel->where("email", Auth::user()->email)->update($data);

    }

    public function updatePassword(array $data)
    {
        $password = Hash::make($data['password']);

        $this->userModel->where("email", Auth::user()->email)->update([
            "password" => $password
        ]);
    }

    public function delete(array $data)
    {
        $password = $data['password'];

        $user = $this->userModel->where("email", Auth::user()->email)->first();

        if (!$user) {
            throw new Exception("Usuário não encontrado");
        }

        if (!Hash::check($password, $user->password)) {
            throw new Exception("Senha inválida");
        }

        $user->destroy($user->id);

    }
}
