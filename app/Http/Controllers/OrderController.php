<?php

namespace App\Http\Controllers;

use App\Helpers\RewardHelper;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Reward;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('id', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    public function create(){
        $users = User::orderBy('name', 'asc')->get();
        $users->map(function($user){
            $user->append('available_points');
        });
        $currencies = Currency::get();
        return view('orders.create', compact('users', 'currencies'));
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'currency_id' => 'required|exists:currencies,id',
            'sales_amount' => 'required|numeric|min:0'
        ]);

        $user = User::findOrFail($request->user_id);
        $currency = Currency::findOrFail($request->currency_id);

        //Create new Order
        $order = new Order;
        $order->user_id = $user->id;
        $order->sales_amount = round($request->sales_amount, 2);
        $order->status = "Pending";
        $order->currency = $currency->code;
        $order->currency_value = $currency->exchange_rate;

        //check if customer want to use the rewards point
        if($request->use_points){
            //convert sales amount to USD
            $amount_to_redeem = $order->sales_amount * $order->currency_value;

            //1 point = USD 0.01
            //1 USD = 100 points
            $points_to_redeem = $amount_to_redeem * 100;

            $user = User::findOrFail($order->user_id);
            
            //Get User's Current Available Reward Points
            $available_points = $user->rewards()->where('expiry_date','>',Carbon::now())->sum('available_points');

            //check if reward points can be used
            if($available_points < $points_to_redeem){
                flash('Enough points not available')->error();
                return redirect()->back();
            }
            
            //get all available, unexpired Points, which has amount available for redemption, in ascending order of expiry date.
            $user_rewards = $user->rewards()->where('expiry_date','>',Carbon::now())->where('available_points','>', 0)->orderBy('expiry_date', 'asc')->get();
            
            foreach($user_rewards as $user_reward){
                //if available_points > points_to_redeem, then we only use the reward partially
                $points_redeemed = min($user_reward->available_points, $points_to_redeem);

                // deduct from available reward points; the reward is either fully used or is used partially if more than required points are available
                $user_reward->available_points -= $points_redeemed;
                $user_reward->save();

                $points_to_redeem -= $points_redeemed;

                if($points_to_redeem == 0)
                    break;
            }
        }

        $order->save();

        flash('Order has been added successfully')->success();

        return redirect()->route('orders.index');
    }

    public function markAsComplete($order_id){
        $order = Order::findOrFail($order_id);

        if($order->status != "Pending")
        {
            flash('Order has already been Completed.')->error();   
            return redirect()->back();
        }

        //Create new reward record
        $reward = new Reward();
        $reward->order_id = $order->id;
        $reward->user_id = $order->user_id;
        $reward->expiry_date = Carbon::now()->addYears(1);

        // convert sales amount to USD and rounded off the result to get reward points.
        $reward_amount = round($order->sales_amount * $order->currency_value);

        $reward->total_points = $reward_amount;
        $reward->available_points = $reward_amount;
        $reward->save();

        //set order status to completed
        $order->status = "Completed";
        $order->save();

        flash('Order has been completed.')->success();  

        return redirect()->back();
    }
}
