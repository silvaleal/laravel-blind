<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Services\AutenticateService;
use Exception;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function __construct(
        protected AutenticateService $authService
    ) {
    }
    public function index()
    {
        return view("user.auth.register");
    }

    public function store(RegisterUserRequest $request)
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
