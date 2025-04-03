@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to Pet Store</h1>
        
        <!-- Search Form -->
        <form action="{{ route('search.results') }}" method="GET">
            <input type="text" name="query" placeholder="Search for items...">
            <button type="submit">Search</button>
        </form>
    </div>
@endsection
