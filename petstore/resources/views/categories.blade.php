@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Categories</h2>
        @foreach($categories as $category)
            <h3>{{ $category->name }}</h3>
            <ul>
                @foreach($category->items as $item)
                    <li>{{ $item->name }} - RM{{ $item->price }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endsection

