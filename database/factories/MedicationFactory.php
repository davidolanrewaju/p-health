<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicationFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');

        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement(['Amoxicillin', 'Lisinopril', 'Metformin', 'Omeprazole', 'Simvastatin']),
            'dosage' => fake()->randomElement(['500mg', '250mg', '1000mg', '100mg', '50mg']),
            'frequency' => fake()->randomElement(['Once daily', 'Twice daily', 'Three times daily', 'Every 8 hours', 'Every 12 hours']),
            'medicationType' => fake()->randomElement(['Tablet', 'Capsule', 'Liquid', 'Injection']),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'instructions' => fake()->sentence(4),
            'requiresFasting' => fake()->boolean(),
            'schedule' => [
                'times' => fake()->randomElements(['08:00', '12:00', '16:00', '20:00'], fake()->numberBetween(1, 4)),
                'daysOfWeek' => fake()->randomElements(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], fake()->numberBetween(1, 7)),
            ],
            'status' => fake()->randomElement(['active', 'inactive', 'completed']),
        ];
    }
}
