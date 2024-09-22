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
                'name' => 'Carlo',
                'email' => 'carlo@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Atom',
                'email' => 'atom@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Eug',
                'email' => 'eug@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Jonel',
                'email' => 'jonel@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Aljon',
                'email' => 'aljon@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Jayson',
                'email' => 'jayson@pho.com',
                'password' => Hash::make('changepassword'),
            ],
            [
                'name' => 'Jayrald',
                'email' => 'jayrald@pho.com',
                'password' => Hash::make('changepassword'),
            ],
        ]);
    }
}
