<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'name' => 'Ugnayan sa Barangay (Caramoran), Oct. 1, 2024',
                'status' => 1,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Pandan), Oct. 4, 2024',
                'status' => 1,
            ],
            [
                'name' => 'Ugnayan sa Barangay (San Miguel), Oct. 7, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Baras), Oct. 9, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Gigmoto), Oct. 11, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Bagamanoc), Oct. 14, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (San Andres), Oct. 16, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Panganiban), Oct. 18, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Bato), Oct. 22, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Viga), Oct. 28, 2024',
                'status' => 0,
            ],
            [
                'name' => 'Ugnayan sa Barangay (Virac), Oct. 30, 2024',
                'status' => 0,
            ],
        ]);
    }
}
