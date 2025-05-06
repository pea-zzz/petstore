<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PawzyPet Store') }}</title>

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
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Pet Store Logo" style="height: 80px; margin-left: 50px;">
        </a>
    </div>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>

            <!-- Admin specific link -->
            @auth
                @if(Auth::user()->role == 'admin')
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    <li><a href="{{ route('admin.items.create') }}">Add Item</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">View Orders</a></li>
                @endif
            @endauth

            <!-- Conditional Links Based on Authentication -->
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
</header>


    <!-- Main Content -->
    <main>
        <div class="container">
            @yield('content') <!-- Content specific to each page will be injected here -->
        </div>
    </main>

    <!-- Main JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Optionally push additional scripts for individual pages -->
    @stack('scripts')

</body>
</html>