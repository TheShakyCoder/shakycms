<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'posts'  => Post::count(),
                'users'  => User::count(),
                'roles'  => Role::count(),
            ],
            'recentPosts' => Post::latest()->limit(5)->get(['id', 'title', 'created_at']),
        ]);
    }
}
