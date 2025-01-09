<?php

namespace Database\Factories;

use App\Models\Spec;
use App\Models\SpecRow;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecRow>
 */
class SpecRowFactory extends Factory
{
    protected $model = SpecRow::class;

    // public function definition()
    // {
    //     return [
    //         'spec_id' => Spec::factory(),
    //         'row_identifier' => $this->faker->numberBetween(1000, 9999), // Example range, adjust as needed
    //         'content' => $this->faker->sentence,
    //         // 'value' => $this->faker->sentence,
    //         'priority' => array_rand(['M', 'S', 'C', 'W']),
    //         'version' => 1,
    //         // 'accepted_at' => $this->faker->boolean ? now() : null,
    //         'accepted_at' =>  0,
    //         'deleted_at' => 0,
    //     ];
    // }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'spec_id' => function () {
            //     return \App\Models\Spec::factory()->create()->id;
            // },
            'content' => $this->faker->sentence,
            'priority' => 'M', // or $this->faker->randomLetter
            'accepted_at' => 0,
        ];
    }

    /**
     * Indicate that the spec row should be a new row with a new row identifier.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function newRow()
    {
        return $this->state(function (array $attributes) {
            return [
                'row_identifier' => null, // The boot method will handle this
                'version' => null, // The boot method will set this to 1 for new rows
            ];
        });
    }

    /**
     * Indicate that the spec row should be a new version of an existing row.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function newVersion()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
