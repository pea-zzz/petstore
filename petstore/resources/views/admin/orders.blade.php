@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Orders</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">No orders found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>
                                @php
                                    $badgeClass = match($order->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'shipped' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>RM{{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach($order->orderItems as $item)
                                        <li>
                                            {{ $item->item->name ?? 'Deleted Item' }} × {{ $item->quantity }}
                                            @ RM{{ number_format($item->price, 2) }}
                                            @if ($item->item_selection)
                                                <small class="text-muted">(Selection: {{ $item->item_selection }})</small>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $order->created_at->diffForHumans() }}<br>
                                <small class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
