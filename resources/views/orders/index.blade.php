@extends('layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">All Orders</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <span>Add New Order</span>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="" action="" id="sort_orders" method="GET">
        {{-- <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">All Orders</h5>
            </div>
        </div> --}}

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="md">Order</th>
                        <th data-breakpoints="md">Customer</th>
                        <th data-breakpoints="md">Sales Amount</th>
                        <th data-breakpoints="md">Status</th>
                        
                        <th class="text-right" width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $order->title }}
                            </td>
                            <td>
                                {{ $order->user->name }}
                            </td>
                            <td>
                                {{ $order->currency }} {{ $order->sales_amount }}
                            </td>
                            <td>
                                <span class="badge {{ $order->status == 'Pending' ? 'badge-warning' : 'badge-success' }}" style="width: unset">{{ $order->status }}</span>
                            </td>
                            
                            <td class="text-right">
                                @if($order->status == 'Pending')
                                    <form action="{{ route('orders.markAsComplete', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-soft-primary btn-sm" title="Mark as Complete">
                                            Mark as Complete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection


@section('script')
   

@endsection
