@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Checkout</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if($list->isEmpty())
            <p>Your cart is empty.</p>
        @else

        <div class="user-info">
            <h3>Shipping Information</h3>
            <p><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
        </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 25%;">Product</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 15%;">Option</th>
                        <th style="width: 15%;">Quantity</th>
                        <th style="width: 20%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td style="vertical-align: middle; text-align: center;">
                                @if(!empty($item->image))
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name ?? 'Item' }}" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td style="vertical-align: middle;">{{ $item->name ?? 'N/A' }}</td>
                            <td style="vertical-align: middle;">RM{{ number_format($item->price ?? 0, 2) }}</td>
                            <td style="vertical-align: middle;">{{ $item->item_selection ?? 'N/A' }}</td>
                            <td style="vertical-align: middle;">{{ $item->qty ?? 0 }}</td>
                            <td style="vertical-align: middle;">RM{{ number_format(($item->price ?? 0) * ($item->qty ?? 0), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 20px;">
                <div style="margin-bottom: 15px;">
                    <h4 style="text-align: right;">Subtotal: RM{{ number_format($subtotal, 2) }}</h4>
                    <h4 style="text-align: right;">Shipping Fee: RM{{ number_format($shippingFee, 2) }}</h4>
                    <h3 style="text-align: right; margin-bottom: 15px;">Total: RM{{ number_format($total, 2) }}</h3>
                </div>

                <!-- Payment method -->
                <div style="text-align: left; margin-bottom: 20px;">
                    <h4>Select Payment Method:</h4><br>
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" style="display: inline;">
                        @csrf
                        <div class="payment-methods">
                            <div class="payment-option">
                                <input type="radio" id="tng" name="payment_method" value="tng" required>
                                <label for="tng">Touch 'n Go</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="shopeepay" name="payment_method" value="shopeepay">
                                <label for="shopeepay">ShopeePay</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="online_banking" name="payment_method" value="online_banking">
                                <label for="online_banking">Online Banking</label>
                            </div>
                        </div>
                        <a href="{{ route('shopping.cart') }}" class="btn btn-secondary" style="margin-right: 10px;">Back to Cart</a>
                        <button type="submit" class="btn btn-success">Confirm Order</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmForm = document.querySelector('#checkoutForm');
            if (confirmForm) {
                confirmForm.addEventListener('submit', function (e) {
                    if (!confirm('Are you sure you want to place this order?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection