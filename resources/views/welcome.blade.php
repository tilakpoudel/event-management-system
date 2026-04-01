<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Event Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10 flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 transition">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <!-- Hero Section -->
                <div class="text-center mb-20">
                    <div class="inline-block bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        ✨ Manage Events Effortlessly
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Event Management<br><span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Made Simple</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-10">
                        Create, manage, and track events with ease. Build meaningful connections and grow your audience with our intuitive event management platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('events.index') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-105 shadow-lg">
                                Browse Events
                            </a>
                            <a href="{{ route('events.create') }}" class="px-8 py-4 bg-white text-blue-600 font-bold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition">
                                Create Your Event
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-105 shadow-lg">
                                Get Started Free
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-blue-600 font-bold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition">
                        <div class="bg-blue-100 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Easy Event Creation</h3>
                        <p class="text-gray-600">
                            Create beautiful events in minutes. Set dates, capacities, and descriptions with our intuitive form interface.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition">
                        <div class="bg-green-100 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Manage Attendees</h3>
                        <p class="text-gray-600">
                            Track bookings, manage capacity, and see who's attending. Keep your events organized and always in control.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition">
                        <div class="bg-purple-100 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-4-4H4a4 4 0 00-4 4v2h16z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Discover Events</h3>
                        <p class="text-gray-600">
                            Browse upcoming events in your area. Find events that match your interests and connect with like-minded people.
                        </p>
                    </div>
                </div>

                <!-- How It Works Section -->
                <div class="bg-white rounded-3xl shadow-xl p-12 border border-gray-100 mb-20">
                    <h2 class="text-4xl font-bold text-gray-900 text-center mb-16">How It Works</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Step 1 -->
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-full font-bold text-2xl mb-6">
                                1
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Sign Up</h3>
                            <p class="text-gray-600 text-sm">Create your account and join our community of event creators and attendees.</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-600 text-white rounded-full font-bold text-2xl mb-6">
                                2
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Create Events</h3>
                            <p class="text-gray-600 text-sm">Set up your event with all the details, dates, and capacity limits you need.</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-600 text-white rounded-full font-bold text-2xl mb-6">
                                3
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Get Bookings</h3>
                            <p class="text-gray-600 text-sm">Users discover and book spots at your events. Watch registrations come in!</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-600 text-white rounded-full font-bold text-2xl mb-6">
                                4
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Run Events</h3>
                            <p class="text-gray-600 text-sm">Execute your event with full attendance tracking and attendee information.</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-8 text-white text-center shadow-lg">
                        <div class="text-4xl font-bold mb-2">{{ \App\Models\Event::count() }}</div>
                        <p class="text-blue-100">Total Events Created</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-8 text-white text-center shadow-lg">
                        <div class="text-4xl font-bold mb-2">{{ \App\Models\Booking::count() }}</div>
                        <p class="text-green-100">Total Bookings</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-8 text-white text-center shadow-lg">
                        <div class="text-4xl font-bold mb-2">{{ \App\Models\User::where('id', '>', 1)->count() }}</div>
                        <p class="text-purple-100">Active Users</p>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-center text-white shadow-xl">
                    <h2 class="text-4xl font-bold mb-6">Ready to Create Your Event?</h2>
                    <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                        Join thousands of event creators who are building amazing experiences with our platform.
                    </p>
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-block px-10 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                            Create Your First Event
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                            Get Started Today
                        </a>
                    @endauth
                </div>
            </div>

            <footer class="bg-gray-900 text-gray-400 py-12 mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p>&copy; 2026 Event Management System. Built with Laravel & Tailwind CSS.</p>
                    <div class="mt-6 flex justify-center gap-6">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                        <a href="#" class="hover:text-white transition">Contact</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
