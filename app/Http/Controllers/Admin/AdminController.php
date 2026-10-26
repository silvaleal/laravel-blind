<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminUserService;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        protected AdminUserService $adminUserService
    ) {}

    public function index(): View
    {
        return view('admin.index', [
            'stats' => $this->adminUserService->dashboardStats(),
            'recentUsers' => $this->adminUserService->recentUsers(),
        ]);
    }
}
