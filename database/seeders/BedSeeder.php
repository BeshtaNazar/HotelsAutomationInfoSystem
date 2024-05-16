<?php

namespace Database\Seeders;

use App\Models\Bed;
use Illuminate\Database\Seeder;


class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bed::create([
            'name' => 'Single',
            'capacity' => '1'
        ]);
        Bed::create([
            'name' => 'Double',
            'capacity' => '2'
        ]);

    }
}
