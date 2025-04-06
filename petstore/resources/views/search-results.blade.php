@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Search Results</h2>
        <ul>
            @foreach($items as $item)
                <li>{{ $item->name }} - RM{{ $item->price }}</li>
            @endforeach
        </ul>
    </div>
@endsection
