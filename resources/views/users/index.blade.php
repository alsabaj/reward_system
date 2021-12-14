@extends('layouts.app')

@section('content')

<div class="card">
    <form class="" action="" id="sort_users" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">All Users</h5>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="md">Name</th>
                        <th data-breakpoints="md">Reward Points</th>
                        
                        <th class="text-right" width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->reward_points }}
                        </td>
                        
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-sm" href="{{ route('users.rewards', $user->id) }}" title="View Reward History">
                                View Reward History
                            </a>
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
