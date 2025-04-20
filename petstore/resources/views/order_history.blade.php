@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/order_history.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Order History</h1>

        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            @foreach($orders as $order)
                <div class="order">
                    <h3>Order #{{ $order->id }} - {{ $order->created_at->format('d M Y, H:i') }}</h3>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Product</th> 
                                <th style="width: 15%;">Price</th>
                                <th style="width: 15%;">Option</th>
                                <th style="width: 15%;">Quantity</th>
                                <th style="width: 25%;">Total</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $item->item->name ?? 'Unknown Product' }}</td>
                                    <td style="vertical-align: middle;">RM{{ number_format($item->price, 2) }}</td>
                                    <td style="vertical-align: middle;">{{ $item->item_selection ?? 'N/A' }}</td>
                                    <td style="vertical-align: middle;">{{ $item->quantity }}</td>
                                    <td style="vertical-align: middle;">RM{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="order-summary">
                        <p><strong>Total:</strong> RM{{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
