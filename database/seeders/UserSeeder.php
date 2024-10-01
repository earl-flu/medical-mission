<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Earl',
                'email' => 'earl@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Norvin',
                'email' => 'norvin@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Jessie',
                'email' => 'jessie@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'John Francis',
                'email' => 'john@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Aljon',
                'email' => 'aljon@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Mik',
                'email' => 'mik@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Demie',
                'email' => 'dem@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Rica',
                'email' => 'rica@pho.com',
                'password' => Hash::make('changepassword'),
            ],

        ]);
    }
}
