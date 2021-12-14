<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateRewardPoints() {
        //sales amount of order
        $sales_amount = $this->sales_amount;

        //value to convert currency to USD 
        $currency_value = $this->currency_value;

        // convert sales amount to USD and rounded off the result to get reward points.
        $reward_amount = round($sales_amount * $currency_value);

        return $reward_amount;
    }
}
