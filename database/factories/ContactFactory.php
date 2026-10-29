<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = \App\Models\Contact::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' =>0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
