<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name'=> 'The Popup Ltd.',
            'company_phone'=> '09781903836',
            'company_email' => 'popup@ninjacompany.com',
            'company_address' => 'No(14) , LanMaTaw std , Magway',
            'office_start_time' => '09:00:00',
            'office_end_time' => '16:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00'
        ];
    }
}
