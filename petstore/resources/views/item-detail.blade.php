<!-- item-detail.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="item-detail">
        <div class="item-info">
            <h1>{{ $item->name }}</h1>
            <!-- Display multiple images -->
            <div class="item-images">
                @foreach($item->images as $image)
                <img src="{{ asset($image->url) }}" alt="{{ $item->name }}" class="item-image">
                @endforeach
            </div>
            <p class="price">RM{{ number_format($item->price, 2) }}</p>

            @if($item->selections->isNotEmpty()) 
                <div class="item-selection">
                    <label for="selection">Choose an option:</label>
                    <select name="selection" id="selection" onchange="updateImage(this)">
                        @foreach($item->selections as $selection)
                            <option value="{{ $selection->id }}" data-image="{{ asset($selection->image_url) }}">
                                {{ $selection->option }}
                            </option>   
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="item-description">
            <h3>Description:</h3>
            {!! nl2br(str_replace('\\n', "\n", e($item->description))) !!}
        </div>
        <br>

        <!-- Display Average Rating -->
        <h3>Average Rating:</h3>
        <p>
            @if($averageRating > 0)
                {{ round($averageRating, 1) }} Stars
            @else
                No ratings yet.
            @endif
        </p>
        <br>
        <!-- Display existing reviews -->
        <h3>Reviews</h3>
        <div style="text-align: left;">
            @if($item->reviews->isEmpty())
                <p>No reviews yet. <a href="{{ route('review.create', $item->id) }}">Be the first to leave a review!</a></p>
            @else
                @foreach($item->reviews as $review)
                    <div class="review">
                         <!-- Check if the user exists before displaying the name -->
                        <p><strong>{{ $review->user ? $review->user->name : 'Unknown User' }}</strong></p>
                        <p>Rating: {{ $review->rating }} stars</p>
                        <p>{{ $review->comment }}</p>
                        <br>
                    </div>
                @endforeach
                <p><strong>Click <a href="{{ route('review.create', $item->id) }}">here</a> to add your review now!</strong></p>
            @endif
        </div>
    </div>

    <!-- Add to Cart Form -->
    <div style="text-align: center; margin-top: 20px;">
    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        @if($item->selections->isNotEmpty())
        <input type="hidden" name="item_selection" id="item_selection" value="">
        @endif
        <input type="number" name="quantity" value="1" min="1" style="width: 60px; margin-right: 10px;">
        <button type="submit" class="btn btn-primary">Add to cart</button>
    </form>

    <script>
        // Function to update the displayed image based on the selected option
        function updateImage(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const newImageUrl = selectedOption.getAttribute('data-image');
            document.getElementById('item-image').src = newImageUrl;
        }
    </script>
    
@endsection


