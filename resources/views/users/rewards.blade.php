@extends('layouts.app')

@section('content')

<div class="card">
    <form class="" action="" id="sort_rewards" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ $user->name }} > Reward History</h5>
            </div>
            <div class="col text-right">
                <a href="{{ route('users.index') }}" class="btn btn-neutral">
                    <i class="las la-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order</th>
                        <th data-breakpoints="md">Total Points Earned</th>
                        <th data-breakpoints="md">Expiry Date</th>
                        <th data-breakpoints="md">Status</th>
                        
                        {{-- <th class="text-right" width="15%"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rewards as $reward)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $reward->order->title }}
                        </td>
                        <td>
                            {{ $reward->reward_points }}
                        </td>
                        <td>
                            {{ date('M j, Y', strtotime($reward->expiry_date)) }}
                        </td>
                        <td>
                            <span class="badge {{ $reward->is_expired ? 'badge-danger' : 'badge-success' }}" style="width: unset">{{ $reward->is_expired ? 'Expired' : 'Active' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </form>
</div>

@endsection


@section('script')
   

@endsection
