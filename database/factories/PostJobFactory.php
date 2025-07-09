<?php

namespace Database\Factories;

use App\Models\PostJob;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostJobFactory extends Factory
{
    protected $model = PostJob::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'job_type_id' => JobType::inRandomOrder()->value('id') ?? JobType::factory(),
            'job_nature' => $this->faker->randomElement(['Full Time', 'Part Time', 'Remote', 'Freelance']),
            'vacancy' => $this->faker->numberBetween(1, 10),
            'salary' => $this->faker->numberBetween(15000, 50000) . ' BDT',
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'benefits' => $this->faker->sentence(),
            'responsibility' => $this->faker->sentence(),
            'qualifications' => $this->faker->sentence(),
            'keywords' => implode(',', $this->faker->words(3)),
            'company_name' => $this->faker->company(),
            'company_location' => $this->faker->address(),
            'website' => $this->faker->url(),
        ];
    }
}
