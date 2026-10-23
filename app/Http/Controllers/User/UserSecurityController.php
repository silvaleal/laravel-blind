<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAccountUpdate;
use App\Http\Requests\UserPasswordUpdate;
use App\Http\Requests\UserSecurityDelete;
use App\Services\UserSecurityService;
use Illuminate\Http\Request;

class UserSecurityController extends Controller
{
    public function __construct(
        protected UserSecurityService $userSecurityService
    ) {
    }

    public function index()
    {
        return view("user.security");
    }

    public function account(UserAccountUpdate $request)
    {
        $data = $request->validated();

        try {
            $this->userSecurityService->updateAccount($data);

            return to_route('user.security')->with("success", "Dados atualizados com sucesso.");
        } catch (\Throwable $th) {
            # TODO: Colocar o tratamento de error
        }
    }

    public function password(UserPasswordUpdate $request)
    {
        $data = $request->validated();

        try {
            $this->userSecurityService->updatePassword($data);

            return to_route('user.security')->with("success", "Dados atualizados com sucesso.");
        } catch (\Throwable $th) {
            # TODO: Colocar o tratamento de error
        }
    }

    public function delete(UserSecurityDelete $request)
    {
        $data = $request->validated();

        try {
            $this->userSecurityService->delete($data);

            return to_route('user.login')->with("success", "Dados atualizados com sucesso.");
        } catch (\Throwable $th) {
            # TODO: Colocar o tratamento de error
        }
    }

}
