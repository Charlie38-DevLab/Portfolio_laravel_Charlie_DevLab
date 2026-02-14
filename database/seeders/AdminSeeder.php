<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@charliedevlab.com'],
            [
                'name' => 'Charlie Admin',
                'password' => Hash::make('Admin@2025'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "✅ Administrateur prêt\n";
        echo "📧 Email    : {$admin->email}\n";
        echo "🔐 Password : Admin@2025\n";
        echo "👤 Rôle     : {$admin->role}\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}
