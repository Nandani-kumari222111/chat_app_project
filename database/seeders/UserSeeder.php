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
    User::insert([
        [
        'name' => 'Nandani',
        'email' => 'nandani@gmail.com',
        'password' => bcrypt('password'),
        ],
    [
    'name' => 'Rahul',
    'email' => 'rahul@gmail.com',
    'password' => bcrypt('password'),
    ],
    [
    'name' => 'Priya',
    'email' => 'priya@gmail.com',
    'password' => bcrypt('password'),
    ],

    [
    'name' => 'Aman',
    'email' => 'aman@gmail.com',
    'password' => bcrypt('password'),
    ],

    [
    'name' => 'Sneha',
    'email' => 'sneha@gmail.com',
    'password' => bcrypt('password'),
    ],                        


    [
    'name' => 'Rohit',
    'email' => 'rohit@gmail.com',
    'password' => bcrypt('password'),
    ],

    [
    'name' => 'Pooja',
    'email' => 'pooja@gmail.com',
    'password' => bcrypt('password'),
    ],

    [
    'name' => 'Vikas',
    'email' => 'vikas@gmail.com',
    'password' => bcrypt('password'),
    ],
    [
    'name' => 'Anjali',
    'email' => 'anjali@gmail.com',
    'password' => bcrypt('password'),
    ],


    [
    'name' => 'Karan',
    'email' => 'karan@gmail.com',
    'password' => bcrypt('password'),
    ],

     [
    'name' => 'Ariya',
    'email' => 'ariya@gmail.com',
    'password' => bcrypt('password'),
    ],

    ]);
     //User::factory()->count(1000)->create();
}
}
