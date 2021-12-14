@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">Create Order</h5>
                </div>
                <div class="col text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-neutral">
                        <i class="las la-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('orders.store') }}">
                	@csrf
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Order Title
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" placeholder="e.g. Order for PC" name="title" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            Customer
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <select class="form-control aiz-selectpicker" id="user_id" name="user_id" data-live-search="true" required>
                                <option disabled selected value="">Choose customer</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" data-available_points="{{ $user->reward_points }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            Currency
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <select class="form-control aiz-selectpicker" id="currency_id" name="currency_id" data-live-search="true" required>
                                <option disabled selected value="">Choose currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" data-exchange_rate="{{ $currency->exchange_rate }}">
                                        {{ $currency->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Sales Amount
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="number" min="1" step="0.01" placeholder="Sales Amount" name="sales_amount" max="100000" class="form-control" required>
                        </div>
                    </div>

                    {{-- <div class="form-group row" id="use_points" hidden>
                        <div class="col-md-3 col-form-label">
                            
                        </div>
                        <div class="col-md-9">
                            <span class="">Available Reward Points: <span id="available_points"></span></span><br>
                            <span class="">Required Reward Points: <span id="required_points"></span></span><br>
                            <label class="mt-2">
                                <input type="checkbox" name="use_points" value="1">
                                <span class="ml-2">Use Reward Points</span>
                            </label>
                        </div>
                    </div> --}}
                    
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-success">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var user_id, currency_id;

            $('#user_id').on('change',function(){
                getPointsAvailable();
            })
            $('#currency_id').on('change',function(){
                getPointsAvailable();
            })
            $("input[name='sales_amount']").on('keyup',function(){
                getPointsAvailable();
            })

            function getPointsAvailable() {
                var available_points = $('#user_id option:selected').data('available_points');
                var exchange_rate = $('#currency_id option:selected').data('exchange_rate');
                var sales_amount = $("input[name='sales_amount']").val();

                console.log('-------------------------------------');
                console.log('available_points: ', available_points);
                console.log('exchange_rate: ', exchange_rate);
                console.log('sales_amount: ', sales_amount);

                if(!available_points || !exchange_rate || !sales_amount) {
                    $("#use_points").attr( "hidden", 'hidden' );
                    $("input[name='use_points']").prop( "checked", false );

                    return;
                };

                var points_to_redeem = parseFloat((sales_amount * exchange_rate).toFixed(2)) * 100;
                console.log('points_to_redeem: ', points_to_redeem);

                if(available_points >= points_to_redeem){
                    $("#use_points").removeAttr( "hidden");
                    $('#available_points').html(available_points);
                    $('#required_points').html(points_to_redeem.toFixed(2));
                    
                }else{
                    $("#use_points").attr( "hidden", 'hidden' );
                    $("input[name='use_points']").prop( "checked", false );
                }

            }
        })
    </script>
    
@endsection
