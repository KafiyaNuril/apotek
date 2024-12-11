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
        // atribut berisi key dan value
        // key => name, email, password, role => dari model User
        // value => admin, admin@example.com, admin1234, admin
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('admin1234'),
        //     'role' => 'admin',
        // ]);

        User::create([
            'name' => 'kafiya',
            'email' => 'kafiya@gmail.com',
            'password' => bcrypt('kafiya1234'),
            'role' => 'cashier',
        ]);
    }
}
