<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeProcess = [
            ['name' => 'Ingeniería', 'prefix' => 'ING'],
            ['name' => 'Medicina', 'prefix' => 'MED'],
            ['name' => 'Derecho', 'prefix' => 'DER'],
            ['name' => 'Física', 'prefix' => 'FIS'],
            ['name' => 'Mecánica', 'prefix' => 'MEC']
        ];
        foreach ($typeProcess as $typeProces) {
            Process::create([
                'prefix' => $typeProces['prefix'],
                'name' => $typeProces['name'],
            ]);
        }
    }
}
