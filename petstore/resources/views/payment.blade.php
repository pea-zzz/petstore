@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Payment Processing</h1>
        <p>Processing your payment of RM{{ number_format(session('order.total'), 2) }} via {{ session('order.payment_method') }}...</p>
        <p>Subtotal: RM{{ number_format(session('order.subtotal'), 2) }}</p>
        <p>Shipping Fee: RM{{ number_format(session('order.shipping_fee'), 2) }}</p>
    </div>

    <div id="paymentSuccessModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Payment Success</h2>
            <p>Your order has been placed successfully! Order #{{ session('order.id') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const modal = document.getElementById('paymentSuccessModal');
                modal.style.display = 'flex';

                const closeBtn = document.querySelector('.close');
                closeBtn.addEventListener('click', function () {
                    modal.style.display = 'none';
                    window.location.href = '/home';
                });
            }, 2000);
        });
    </script>
@endsection