<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\AutenticateService;
use Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(
        protected AutenticateService $authService
    ) {
    }
    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return to_route("user.login");
    }
}
