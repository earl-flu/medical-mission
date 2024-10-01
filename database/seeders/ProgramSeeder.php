<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'code' => 'IHCP',
                'name' => '',
                'description' => '',
            ],
            [
                'code' => 'MENTAL',
                'name' => '',
                'description' => '',
            ],
            [
                'code' => 'SMP',
                'name' => '',
                'description' => '',
            ],
            [
                'code' => 'MNCHN',
                'name' => '',
                'description' => '',
            ],
            [
                'code' => 'NONCOM',
                'name' => '',
                'description' => '',
            ],
        ];

        foreach ($programs as $program) {
            DB::table('programs')->insert([
                'code' => $program['code'],
                'name' => $program['name'],
                'description' => $program['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
