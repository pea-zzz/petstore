<!-- item-detail.blade.php -->
@extends('layouts.app')

@section('content')

    <!-- Flash message popup -->
    @if(session('success'))
        <div id="successMessage" class="alert alert-success"
            style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                font-size: 1.5rem;
                padding: 2rem 3rem;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                background-color:rgb(152, 199, 230);
                color:rgb(0, 0, 0);
                text-align: center;
                animation: fadeInOut 3s ease-in-out;
            ">
            {{ session('success') }}
        </div>

        <style>
            @keyframes fadeInOut {
                0% { opacity: 0; transform: translate(-50%, -60%); }
                10% { opacity: 1; transform: translate(-50%, -50%); }
                90% { opacity: 1; transform: translate(-50%, -50%); }
                100% { opacity: 0; transform: translate(-50%, -40%); }
            }
        </style>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) msg.remove();
            }, 3500);
        </script>
    @endif

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
                    <select name="selection" id="selection">
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

        <br><br><br><br>

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
    </div>

    <script>
        // Selection image preview (optional)
        function updateImage(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const newImageUrl = selectedOption.getAttribute('data-image');
            // Optional image swap logic here, if you want preview
        }

        // Sync selection value to hidden input
        document.getElementById("selection")?.addEventListener("change", function () {
            document.getElementById("item_selection").value = this.value;
        });

        // Set default on page load
        document.addEventListener("DOMContentLoaded", function () {
            const selection = document.getElementById("selection");
            if (selection) {
                document.getElementById("item_selection").value = selection.value;
            }
        });
    </script>

@endsection
