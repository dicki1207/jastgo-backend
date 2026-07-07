<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jastiper;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

      
        // ----------------------
        // Admin
        // ----------------------
        User::create([
            'name'           => 'Admin User',
            'nama_lengkap'   => 'Administrator',
            'username'       => 'admin123',
            'email'          => 'admin@example.com',
            'password'       => Hash::make('password123'), // hashed password
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. Admin No. 1',
            'role'           => 'admin',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);
        User::create([
            'name'           => 'Admin User Gmail',
            'nama_lengkap'   => 'Administrator Gmail',
            'username'       => 'admin_gmail',
            'email'          => 'admin@gmail.com',
            'password'       => Hash::make('password123'), // hashed password
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. Admin No. 1',
            'role'           => 'admin',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);

        // ----------------------
        // User Biasa
        // ----------------------
        User::create([
            'name'           => 'User',
            'nama_lengkap'   => 'User Biasa',
            'username'       => 'User01',
            'email'          => 'user@example.com',
            'password'       => Hash::make('password123'), // hashed password
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. User No. 1',
            'role'           => 'pengguna',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);
        User::create([
            'name'           => 'User Gmail',
            'nama_lengkap'   => 'User Biasa Gmail',
            'username'       => 'User02',
            'email'          => 'user@gmail.com',
            'password'       => Hash::make('password123'), // hashed password
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. User No. 1',
            'role'           => 'pengguna',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);

        // ----------------------
        // Jastiper
        // ----------------------
        $jastiperUser = User::create([
            'name'           => 'Jastiper User',
            'nama_lengkap'   => 'Jasa Titip User',
            'username'       => 'jastiper01',
            'email'          => 'jastiper@example.com',
            'password'       => Hash::make('jastiper123'), 
            'no_hp'          => '081298765432',
            'alamat'         => 'Jl. Jastiper No. 2',
            'role'           => 'jastiper',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);

        Jastiper::create([
            'user_id' => $jastiperUser->id,
            'nama_toko' => 'Toko Jastiper',
            'no_hp' => '081298765432',
            'jangkauan' => 'Seluruh Indonesia',
            'rating' => 4.5,
            'tanggal_daftar' => now(),
            'rekening_id' => null,
        ]);

        $jastiperUserGmail = User::create([
            'name'           => 'Jastiper User Gmail',
            'nama_lengkap'   => 'Jasa Titip User Gmail',
            'username'       => 'jastiper_gmail',
            'email'          => 'jastiper@gmail.com',
            'password'       => Hash::make('jastiper123'), 
            'no_hp'          => '081298765432',
            'alamat'         => 'Jl. Jastiper No. 2',
            'role'           => 'jastiper',
            'email_verified_at' => now(),
            'tanggal_daftar' => now(),
        ]);

        Jastiper::create([
            'user_id' => $jastiperUserGmail->id,
            'nama_toko' => 'Toko Jastiper Gmail',
            'no_hp' => '081298765432',
            'jangkauan' => 'Seluruh Indonesia',
            'rating' => 4.5,
            'tanggal_daftar' => now(),
            'rekening_id' => null,
        ]);
    }

}
