<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 用户的默认头像
        $avatars = [
            'http://larabbs.test/avatar/cwxp10mxx2v10.jpg',
            'http://larabbs.test/avatar/dboy.png',
            'http://larabbs.test/avatar/knight.jpg',
            'http://larabbs.test/avatar/ueoxofiwt1u7.jpg',
            'http://larabbs.test/avatar/z0rzlcz3q5w4.jpg',
            'http://larabbs.test/avatar/zbylsjmzrxj11.jpg',
            'http://larabbs.test/avatar/zovoi0uuifa6.jpg',
        ];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'introduction' => $this->faker->sentence(),
            'avatar' => $this->faker->randomElement($avatars),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
