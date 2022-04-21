<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;



class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => "Si Thu Htet",
            'email' => "sithuhtet.kosi21@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('asdqwefr'), // password
            'phone' => "09781903836",
            'nrc_number' => "0/abc(N)09888",
            'birthday' => "2000-09-21",
            'gender' => "male",
            'address' => "address",
            'employee_id' => "e_0001",
            'pin' => "111111",
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
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
