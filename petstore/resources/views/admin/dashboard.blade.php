@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin!</p>
    <br>
    <p>You can</p>

    <ul>
        <li><a href="{{ route('home') }}">View Home Page</a></li>
        <br>
        <li><a href="{{ route('admin.items.create') }}">Add Item</a></li>
        <br>
        <li><a href="{{ route('admin.orders.index') }}">View Orders</a></li>
    </ul>
</div>
@endsection