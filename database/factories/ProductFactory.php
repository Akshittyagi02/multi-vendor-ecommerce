<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure there's at least one user to assign products to
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;

        $productName = $this->faker->words(rand(2, 5), true); // Generate 2-5 words for product name

        return [
            'user_id' => $userId,
            'name' => $productName,
            'slug' => Str::slug($productName) . '-' . $this->faker->unique()->numberBetween(1000, 9999), // Add unique suffix to slug
            'description' => $this->faker->paragraph(rand(3, 7)),
            'image' => null, // You can add placeholder images if desired, e.g., 'https://placehold.co/600x400/E5E7EB/1F2937?text=Product+Img'
            'price' => $this->faker->randomFloat(2, 10, 1000), // Price between 10 and 1000
            'sale_price' => $this->faker->boolean(30) ? $this->faker->randomFloat(2, 5, 900) : null, // 30% chance of sale price
            'stock_quantity' => $this->faker->numberBetween(0, 200), // Stock between 0 and 200
            'is_approved' => $this->faker->boolean(70), // 70% chance of being approved
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
