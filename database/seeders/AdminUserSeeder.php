<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Username sulit ditebak: kombinasi singkatan + tahun + identifier
        // Password kuat: berkaitan dengan MTs Nurul Falaah Soreang
        User::updateOrCreate(
            ['username' => 'mtsnfs_cp_2025'],
            [
                'name' => 'Admin',
                'password' => Hash::make('MTsNurulFalaah_Soreang2025!'),
            ]
        );

        $this->command->info('Akun admin berhasil dibuat!');
        $this->command->info('Username: mtsnfs_cp_2025');
        $this->command->info('Password: MTsNurulFalaah_Soreang2025!');
        $this->command->warn('Simpan kredensial ini dengan aman!');
    }
}
