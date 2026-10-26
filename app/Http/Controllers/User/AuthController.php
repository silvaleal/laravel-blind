<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutenticateRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AutenticateService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AutenticateService $authService
    ) {}

    public function index()
    {
        return view('user.auth.login');
    }

    public function store(AutenticateRequest $request)
    {
        try {
            $data = $request->validated();

            $this->authService->login($data);

            return to_route('user.index');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return to_route('user.login');
    }

    public function registerIndex()
    {
        return view('user.auth.register');
    }

    public function registerStore(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();

            $this->authService->register($data);

            return to_route('user.index');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
