@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shopping_cart.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($list->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 20%;">Product</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 15%;">Option</th>
                        <th style="width: 15%;">Quantity</th>
                        <th style="width: 15%;">Total</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td style="vertical-align: middle; text-align: center;">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td style="vertical-align: middle;">{{ $item->name }}</td>
                            <td style="vertical-align: middle;">RM{{ number_format($item->price, 2) }}</td>
                            <td style="vertical-align: middle;">{{ $item->item_selection ?? 'N/A' }}</td>
                            <td style="vertical-align: middle;">
                                <form action="{{ route('cart.update', $item->item_id) }}" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" style="width: 60px; padding: 5px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td style="vertical-align: middle;">RM{{ number_format($item->price * $item->qty, 2) }}</td>
                            <td style="vertical-align: middle;">
                                <form action="{{ route('cart.remove', $item->item_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 20px;">
                <h3 style="margin-bottom: 15px;">Total: RM{{ number_format($total, 2) }}</h3>
                <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @endif
    </div>
@endsection