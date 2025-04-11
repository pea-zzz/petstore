<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pet Store') }}</title>

    <!-- Link to your main CSS file -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Optionally push additional styles for individual pages -->
    @stack('styles')
    @yield('styles')

</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="{{ route('home') }}">Pet Store</a>
        </div>

        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('categories') }}">Categories</a></li>
                <li><a href="{{ route('profile') }}">Profile</a></li>
                <li><a href="{{ route('browsing.history') }}">Browsing History</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('search.results') }}">Search</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            @yield('content') <!-- Content specific to each page will be injected here -->
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Pet Store. All rights reserved.</p>
            <ul>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </footer>

    <!-- Main JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Optionally push additional scripts for individual pages -->
    @stack('scripts')

</body>
</html>

