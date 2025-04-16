<!-- categories.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Pet Gears</h1>
        
        <!-- Filter Form -->
        <form action="{{ route('categories.filter') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <h4>Sort By Category:</h4>
                <select name="category_id" class="form-select">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <h4>Sort By Price Range:</h4>
                <input type="number" name="price_min" class="form-control" placeholder="Min Price" value="{{ request('price_min') }}">
            </div>

            <div class="col-md-3">
                <input type="number" name="price_max" class="form-control" placeholder="Max Price" value="{{ request('price_max') }}">
            </div>

            <div class="col-md-2">
                <h4>Sort By Average Ratings:</h4>
                <select name="rating" class="form-select">
                    <option value="">Any Rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ $i }} stars & up
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <button type="button" class="btn btn-secondary w-100" onclick="window.location='{{ route('categories') }}'">Reset</button>
            </div>
        </form>

        <!-- Display Filtered Items -->
        <br>
        <h3>Filtered Results</h3>
        <br>
        @if($items->isEmpty())
            <p>No items found matching your filters.</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <a href="{{ route('items.show', $item->id) }}">
                                    <p class="card-title"><strong>{{ $item->name }}</strong>
                                </a>
                                - RM{{ number_format($item->price, 2) }}
                                    </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection






