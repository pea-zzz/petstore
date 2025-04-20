<!-- home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to Pawzy Pet Store</h1>

    <!-- Search Form -->
    <form action="{{ route('search.results') }}" method="GET" class="d-flex mb-5">
        <input type="text" name="query" placeholder="Search for items..." class="form-control me-2" required>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    
    <!-- Our Philosophy Section -->
    <section class="mt-5 mb-5 p-4 bg-light rounded shadow-sm">
        <h2>Our Philosophy</h2>
        <p>At Pet Store, we believe every pet deserves the best care, love, and products to lead a happy and healthy life. We're passionate about connecting pet owners with quality supplies that ensure their companions thrive.</p>
    </section>
    
    <!-- About Us Preview Section -->
    <section class="mt-5 mb-5 p-4 bg-light rounded shadow-sm">
        <h2>About Us</h2>
        <p>Founded with a love for animals, our store brings you premium pet products backed by a team that genuinely cares. Want to know more about our journey and mission?</p>
        <p>We invite you to <a href="{{ route('about') }}" class="btn btn-outline-secondary mt-2"><strong>explore our story</strong></a> and discover how we strive to make a difference in the lives of pets and their owners. <br>
    </section>
    
    <!-- Contact Us Section -->
    <section class="mt-5 mb-5 p-4 bg-light rounded shadow-sm">
        <h2>Owned Media</h2>
        <ul class="list-unstyled">
            <li><i class="bi bi-facebook"></i> <a href="https://facebook.com" target="_blank">Facebook</a></li>
            <li><i class="bi bi-twitter"></i> <a href="https://twitter.com" target="_blank">Twitter</a></li>
            <li><i class="bi bi-instagram"></i> <a href="https://instagram.com" target="_blank">Instagram</a></li>
        </ul>
        <br>
        <p>Want to know more? Feel free to <a href="{{ route('contact') }}" class="btn btn-outline-primary mt-3"><strong>contact us</strong></a>  !</p>
    </section>
</div>
@endsection






