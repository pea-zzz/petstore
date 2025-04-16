@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div>
            <label>Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" pattern="\d{10,}" title="Phone number must be at least 10 digits">
        </div>

        <div>
            <label>Address</label>
            <textarea name="address">{{ old('address', auth()->user()->address) }}</textarea>
        </div>

        <button type="submit">Update Profile</button>
    </form>
@endsection
