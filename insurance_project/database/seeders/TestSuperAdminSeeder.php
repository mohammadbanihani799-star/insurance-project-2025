<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update test admin (super_admin)
        Admin::updateOrCreate(
            ['email' => 'admin@insurance.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password123'),
                'status' => 1, // 1 = Active
                'type' => 1, // 1 = Super Admin
                'phone' => '0500000000',
            ]
        );

        $this->command->info('✅ Test Admin created successfully!');
        $this->command->info('📧 Email: admin@insurance.com');
        $this->command->info('🔑 Password: password123');
    }
}
