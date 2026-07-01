<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Privilege;
use App\Models\Right;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'support@fig.ltd.uk',
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'is_admin' => true
        ]);
        $user = User::create([
            'name' => 'Editor',
            'email' => 'manager@stupidly.uk',
            'email_verified_at' => now(),
            'password' => Hash::make(env('EDITOR_PASSWORD')),
        ]);

        $editorRole = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
        ]);

        Privilege::create([
            'role_id' => $editorRole->id,
            'user_id' => $user->id,
        ]);
    }
}
