@extends('layouts.app')

@section('content')
    <div class="review-form">
        <h1>Leave a Review for {{ $item->name }}</h1>
        <form action="{{ route('review.store', $item->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="rating">Rating:</label>
                <input type="number" name="rating" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea name="comment" rows="4" required placeholder="Write your review here..."></textarea>
            </div>
            <button type="submit">Submit Review</button>
        </form>
    </div>
@endsection
