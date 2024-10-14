<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'          => 'admin',
            'email'         => 'admin@gmail.com',
            'departemen'    => 'admin',
            'password'      => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        $produksi = User::create([
            'name'          => 'produksi',
            'email'         => 'produksi@gmail.com',
            'departemen'    => 'produksi',
            'password'      => bcrypt('password')
        ]);
        $produksi->assignRole('peg.produksi');

        $level = User::create([
            'name'          => 'level',
            'email'         => 'level@gmail.com',
            'departemen'    => 'level',
            'password'      => bcrypt('password')
        ]);
        $level->assignRole('c.level');
    
    }
}
