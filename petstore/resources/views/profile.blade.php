@extends('layouts.app')

@section('content')
    <h1>User Profile</h1>

        @php
            $inputStyle = 'width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;';
            $labelStyle = 'display: block; margin-bottom: 5px;';
            $containerStyle = 'margin-bottom: 15px;';
            $buttonStyle = 'padding: 10px 15px; background-color: #2e2e2d; color: white; border: none; border-radius: 4px; cursor: pointer;';
        @endphp

        <div style="{{ $containerStyle }}">
            <label style="{{ $labelStyle }}"><strong>Name</strong></label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" disabled style="{{ $inputStyle }}">
        </div>

        <div style="{{ $containerStyle }}">
            <label style="{{ $labelStyle }}"><strong>Email</strong></label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" disabled style="{{ $inputStyle }}">
        </div>

        <div style="{{ $containerStyle }}">
            <label style="{{ $labelStyle }}"><strong>Phone Number</strong></label>
            <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) ?: 'N/A' }}" disabled style="{{ $inputStyle }}">
        </div>

        <div style="{{ $containerStyle }}">
            <label style="{{ $labelStyle }}"><strong>Address</strong></label>
            <textarea name="address" disabled style="{{ $inputStyle }}">{{ old('address', auth()->user()->address) ?: 'N/A' }}</textarea>
        </div>
        
        <a href="{{ route('profile.edit') }}">
            <button type="button" style="{{ $buttonStyle }}">
            Edit Profile
            </button>
        </a>
@endsection


