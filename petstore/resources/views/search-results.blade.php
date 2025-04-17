<!-- search-results.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Search Results for "{{ $query }}"</h2>
        <br>
        @if ($message)
            <div class="alert alert-warning">{{ $message }}</div>
        @else
            <ul class="list-group">
                @foreach($items as $item)
                    <li class="list-group-item">
                        <a href="{{ route('items.show', $item->id) }}">
                            {{ $item->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
        <br><br>
        <p>Not what you want?</p>
        <p>Please <a href="{{ route('home') }}" class="btn btn-secondary mt-3">search again</a>!</p>
    </div>
@endsection



