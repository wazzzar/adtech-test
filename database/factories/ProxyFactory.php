<?php

namespace Database\Factories;

use App\Models\Proxy;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProxyFactory extends Factory
{
    protected $model = Proxy::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug(2),
            'address' => $this->faker->ipv4(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
