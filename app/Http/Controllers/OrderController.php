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
        $currencies = Currency::get();
        return view('orders.create', compact('users', 'currencies'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'user_id' => 'required|exists:users,id',
            'currency_id' => 'required|exists:currencies,id',
            'sales_amount' => 'required|numeric|min:0'
        ]);

        $user = User::findOrFail($request->user_id);
        $currency = Currency::findOrFail($request->currency_id);

        //Create new Order
        $order = new Order;
        $order->title = $request->title;
        $order->user_id = $user->id;
        $order->sales_amount = round($request->sales_amount, 2);
        $order->status = "Pending";
        $order->currency = $currency->code;
        $order->currency_value = $currency->exchange_rate;

        $order->save();

        flash('Order has been added successfully')->success();

        return redirect()->route('orders.index');
    }

    public function markAsComplete($order_id){
        $order = Order::findOrFail($order_id);
        $user = User::findOrFail($order->user_id);

        if($order->status != "Pending")
        {
            flash('Order status cannot be updated')->error();   
            return redirect()->back();
        }

        $reward_amount = $order->calculateRewardPoints();

        //Create new reward record
        $reward = new Reward();
        $reward->order_id = $order->id;
        $reward->expiry_date = Carbon::now()->addYears(1)->format('Y-m-d');
        $reward->reward_points = $reward_amount;
        $reward->save();

        //credit reward points to the user
        $user->reward_points += $reward_amount;
        $user->save();

        //set order status to completed
        $order->status = "Completed";
        $order->save();

        flash('Order has been completed.')->success();  

        return redirect()->back();
    }
}
