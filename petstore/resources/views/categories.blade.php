@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Pet Gears</h1>
        
        <!-- Filter Form -->
        <form action="{{ route('categories.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label"><strong>Sort By Category:</strong></label>
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
                <label class="form-label"><strong>Sort by Price (Min):</strong></label>
                <input type="number" name="min_price" class="form-control" placeholder="e.g. 10" value="{{ request('min_price', 0) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label"><strong>Sort by Price (Max):</strong></label>
                <input type="number" name="max_price" class="form-control" placeholder="e.g. 200" value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label"><strong>Sort by Average Ratings:</strong></label>
                <select name="min_rating" class="form-select">
                    <option value="">Any Rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('min_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} stars & up
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-50 me-2">Filter</button>
                <button type="button" class="btn btn-secondary w-50" onclick="window.location='{{ route('categories.index') }}'">Reset</button>
            </div>
        </form>
        <br>

        <!-- Display Filtered Items -->
        <hr>
        <h2 class="mb-3">Filtered Results</h2><br>
        
        @if($items->isEmpty())
            <p>No items found matching your filters.</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" style="border: 1px solid #ccc;">
                            <div class="card-body">
                                <p class="card-title mb-1">
                                    <strong>
                                        <a href="{{ route('items.show', $item->id) }}" class="text-decoration-none">
                                            {{ $item->name }}
                                        </a>
                                    </strong>
                                </p>
                                <p class="card-text">RM{{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection








