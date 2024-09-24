<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'name' => 'Xray Services for Children',
                'status' => 1,
            ],
            [
                'name' => 'Oral Health Services',
                'status' => 1,
            ],
            [
                'name' => 'MNCHN Services',
                'status' => 1,
            ],
            [
                'name' => 'Mental Health Services',
                'status' => 1,
            ],
            [
                'name' => 'WAsH Services',
                'status' => 1,
            ],
            [
                'name' => 'Catanduanes Eye Care Services',
                'status' => 1,
            ],
            [
                'name' => 'Immunization of Senior Citizen',
                'status' => 1,
            ],
            [
                'name' => 'Lifestyle Related Diseases Services',
                'status' => 1,
            ],
        ]);
    }
}
