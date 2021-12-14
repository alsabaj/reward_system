<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('orders')->insert([
            'title' => 'Black Friday Order',
            'status' => 'Completed',
            'sales_amount' => 500,
            'currency' => 'USD',
            'currency_value' => 1,
            'user_id' => 1,
            'created_at' => '2020-12-13 12:30:00',
            'updated_at' => '2020-12-13 12:30:00',
        ]);

        \DB::table('rewards')->insert([
            'expiry_date' => '2020-12-13',
            'is_expired' => 0,
            'reward_points' => 500,
            'order_id' => 1
        ]);
    }
}
