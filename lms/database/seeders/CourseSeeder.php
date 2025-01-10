<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standards = [
            'Software Developer Level 4',
            'Software Tester Level 4',
            'Dev Ops Level 4',
            'Digital Product Management Level 4',
            'Digital Accessibility Specialist Level 4',
            'Associate Project Manager Level 4',
            'Cyber Security Level 4',
            'Data Engineering Level 5',
            'Data Analyst Level 4',
            'Cloud Specialist Level 3',
        ];

        foreach ($standards as $standard) {
            Course::create([
                'name' => $standard,
            ]);
        }
    }
}
