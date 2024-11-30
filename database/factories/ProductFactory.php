<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    static $i = 1;

    public function definition(): array
    {
        return [
            'name' => 'Urun ' . self::$i++,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(10),
            'image' => 'products/' . $this->faker->unique()->md5 . '.jpg',
        ];
    }
}
