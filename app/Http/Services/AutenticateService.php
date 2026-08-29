<?php

namespace App\Http\Services;

use App\Models\User;
use Auth;
use Exception;
use Hash;

class AutenticateService
{
    public function __construct(
        protected User $userModel
    ) {
    }

    # Método para autenticar um usuário
    public function login(array $data)
    {
        $account = $this->userModel->where([
            "email" => $data['email']
        ])->first();

        if (!$account) {
            throw new Exception(__("auth.failed"));
        }


        if (!Hash::check($data['password'], $account->password)) {
            throw new Exception(__("auth.failed"));
        }

        return $this->attempt($account);

    }

    # Método para registrar um usuário
    public function register(array $data)
    {
        $account = $this->userModel->where([
            "email" => $data['email']
        ])->first();

        if ($account) {
            throw new Exception("email_exists");
        }

        $user = $this->userModel->create([
            "email"=>$data['email'],
            "name"=>$data['name'],
            "password"=>Hash::make($data['password']),
        ]);

        return $this->attempt($user);
    }

    # Método para salvar a sessão
    public function attempt(User $account)
    {
        return Auth::login($account);
    }

}
