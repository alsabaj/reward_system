<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'exchange_rate' => '1.00',
        ]);

        \DB::table('currencies')->insert([
            'name' => 'Euro',
            'code' => 'EUR',
            'symbol' => '€',
            'exchange_rate' => '1.13',
        ]);
    }
}
