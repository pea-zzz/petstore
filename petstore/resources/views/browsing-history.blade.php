@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Browsing History</h2>
        <ul>
            @foreach(session('browsing_history', []) as $item)
                <li>{{ $item->name }} - RM{{ $item->price }}</li>
            @endforeach
        </ul>
    </div>
@endsection
