@extends('layouts.app')

@section('content')
    <h1>Browsing History</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($histories->isEmpty())
        <p>No browsing history yet.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
            @foreach ($histories as $history)
                @php $item = isset($history->item) ? $history->item : $history; @endphp
                <div style="border: 1px solid #ccc; border-radius: 8px; padding: 10px;">
                    <h3>{{ $item->name }}</h3>
                    <p>Price: RM{{ number_format($item->price, 2) }}</p>
                    <a href="{{ route('items.show', $item->id) }}">View Item</a>
                </div>
            @endforeach
        </div>

        <form action="{{ route('browsing.history.clear') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="background-color: #e3342f; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
                Clear History
            </button>
        </form>
    @endif
@endsection


