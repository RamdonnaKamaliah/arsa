<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id_user' => Str::uuid(),
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_blokir' => false,
            'masa_blokir' => null,
            
        ]);
        
        User::create([
            'id_user' => Str::uuid(),
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'status_blokir' => false,
            'masa_blokir' => null,
            
        ]);
        
        User::create([
            'id_user' => Str::uuid(),
            'name' => 'Peminjam',
            'email' => 'peminjam@gmail.com',
            'password' => Hash::make('peminjam123'),
            'role' => 'peminjam',
            'status_blokir' => false,
            'masa_blokir' => null,
            
        ]);
    }
}