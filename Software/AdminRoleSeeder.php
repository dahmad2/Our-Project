<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'muhammadtalhanizami@outlook.com')->first();

        if ($user) {
            $user->role = 'admin';
            $user->is_approved = true;
            $user->save();

            echo "Admin privileges assigned successfully.\n";
        } else {
            echo  "User not found.\n";
        }
    }
}
