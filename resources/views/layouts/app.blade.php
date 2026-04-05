<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <nav>
                    <nav class="bg-white shadow mb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8">
                {{-- Nav links with active class --}}
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Dashboard
                </a>
                <a href="{{ route('rooms.index') }}" 
                   class="inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium {{ request()->routeIs('rooms.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Rooms
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('rooms.create') }}" 
                           class="inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium {{ request()->routeIs('rooms.create') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            Add Room
                        </a>
                    @endif
                @endauth
            </div>

            <div class="flex space-x-4">
                @guest
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('login') ? 'text-indigo-600' : 'text-gray-500' }}">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('register') ? 'text-indigo-600' : 'text-gray-500' }}">
                        Register
                    </a>
                @endguest
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
            </nav>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
