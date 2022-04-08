<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence;

        $description = collect($this->faker->paragraphs(rand(5, 15)))
            ->map(function ($item) {
                return "<p>$item</p>";
            })->toArray();

        $description = implode($description);

        return [
            'name' => $name,
            'description' => $description,
        ];
    }
}
