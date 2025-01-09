<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Spec;
use App\Models\SpecRow;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spec>
 */
class SpecFactory extends Factory
{
    protected $model = Spec::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'status' => false,
        ];
    }

    // public function configure()
    // {
    //     return $this->afterCreating(function (Spec $spec) {
    //         // Create 10 SpecRow instances for each Spec
    //         SpecRow::factory()->count(10)->create(['spec_id' => $spec->id]);
    //     });
    // }
}
