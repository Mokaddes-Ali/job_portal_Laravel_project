<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Full Time', 'Part Time', 'Internship', 'Remote'];

        foreach ($types as $type) {
            JobType::create(['name' => $type, 'status' => 1]);
        }
    }
}

