<?php

namespace Database\Factories;

use App\Domains\Images\Models\Image;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => $this->faker->randomElement(User::all()),
            "filename" => "mock_image",
            "path" => "mock/images/",
            "extension" => "jpg",
        ];
    }
}
