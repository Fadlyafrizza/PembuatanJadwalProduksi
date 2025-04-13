<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory(20)->create();
        \App\Models\Mesin::factory(20)->create();
        \App\Models\Produk::factory(20)->create();

        \App\Models\BahanBaku::create([
            'nama_bahan' => 'Bahan Baku 1',
            'stok' => 100,
        ]);
        \App\Models\BahanBaku::create([
            'nama_bahan' => 'Bahan Baku 2',
            'stok' => 200,
        ]);
        \App\Models\BahanBaku::create([
            'nama_bahan' => 'Bahan Baku 3',
            'stok' => 300,
        ]);
        \App\Models\BahanBaku::create([
            'nama_bahan' => 'Bahan Baku 4',
            'stok' => 400,
        ]);
    }
}
