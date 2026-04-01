<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                👋 {{ __('Welcome back, ') }}{{ auth()->user()->name }}!
            </h2>
            <p class="text-gray-600 text-sm mt-2">{{ __('Manage your events and bookings from here') }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Events Created -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">{{ __('Events Created') }}</p>
                            <h3 class="text-4xl font-bold text-blue-600">{{ auth()->user()->events()->count() }}</h3>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <span class="text-green-600 font-semibold">{{ auth()->user()->events()->where('date', '>', now())->count() }}</span> upcoming
                    </div>
                </div>

                <!-- Total Bookings Made -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">{{ __('Bookings Made') }}</p>
                            <h3 class="text-4xl font-bold text-green-600">{{ auth()->user()->bookings()->count() }}</h3>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7 4a3 3 0 000 6h10a1 1 0 100-2H7a1 1 0 000-2h10a3 3 0 00-3-3H7a3 3 0 000 6v1a1 1 0 001 1h1a1 1 0 100-2H8v-1a3 3 0 00-1-6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <span class="text-green-600 font-semibold">{{ auth()->user()->bookings()->count() }}</span> confirmed
                    </div>
                </div>

                <!-- Total Attendees -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">{{ __('Total Attendees') }}</p>
                            <h3 class="text-4xl font-bold text-purple-600">
                                @php
                                    $totalAttendees = auth()->user()->events()->with('bookings')->get()->sum(function($event) {
                                        return $event->bookings->count();
                                    });
                                @endphp
                                {{ $totalAttendees }}
                            </h3>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-4-4H4a4 4 0 00-4 4v2h16z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <span class="text-purple-600 font-semibold">joined your events</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-12 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Quick Actions') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('events.create') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-md hover:shadow-lg">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-bold">{{ __('Create New Event') }}</span>
                    </a>

                    <a href="{{ route('events.index') }}" class="flex items-center p-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition shadow-md hover:shadow-lg">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 100-2H6a6 6 0 016 6v3h3a1 1 0 100 2h-3v3a6 6 0 01-6 6H6a1 1 0 100 2h2a2 2 0 002-2v-1a1 1 0 100-2V4a1 1 0 100 2h3a4 4 0 00-4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-bold">{{ __('Browse Events') }}</span>
                    </a>

                    <a href="{{ route('bookings.index') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl hover:from-purple-600 hover:to-purple-700 transition shadow-md hover:shadow-lg">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM15 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
                        </svg>
                        <span class="font-bold">{{ __('My Bookings') }}</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition shadow-md hover:shadow-lg">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.fraternity-3.957.286 0 00-1.971 0c-1.56.38-1.56 2.6 0 2.98a1.532 1.532 0 01-1.572 2.286c-1.56.38-1.56 2.6 0 2.98a1.533 1.533 0 011.572 2.286c-.38 1.56.42 2.6 1.981 2.98a1.532 1.532 0 011.572 2.286c.38 1.56 2.6 1.56 2.98 0a1.533 1.533 0 012.286 1.572c1.56.38 2.6-.42 2.98-1.981a1.533 1.533 0 012.286-1.572c1.56.38 2.6-2.6 2.98-2.98a1.532 1.532 0 011.572-2.286c.38-1.56-.42-2.6-1.981-2.98a1.532 1.532 0 01-1.572-2.286c.38-1.56.42-2.6-1.571-2.98zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-bold">{{ __('Settings') }}</span>
                    </a>
                </div>
            </div>

            <!-- Your Events Section -->
            @if(auth()->user()->events()->count() > 0)
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ __('Your Recent Events') }}</h3>
                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">{{ __('View All') }} →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(auth()->user()->events()->latest()->take(3)->get() as $event)
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-12"></div>
                                <div class="p-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $event->title }}</h4>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description ?: 'No description' }}</p>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                            </svg>
                                            <span>{{ $event->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ $event->bookings()->count() }} booked</span>
                                            </div>
                                            @if($event->isPast())
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">{{ __('Past') }}</span>
                                            @else
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ __('Upcoming') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-6 space-y-2">
                                        <a href="{{ route('events.show', $event) }}" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition text-sm">
                                            {{ __('View') }}
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition text-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Bookings Section -->
            @if(auth()->user()->bookings()->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ __('Your Recent Bookings') }}</h3>
                        <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">{{ __('View All') }} →</a>
                    </div>
                    <div class="space-y-3">
                        @foreach(auth()->user()->bookings()->latest()->take(3)->get() as $booking)
                            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $booking->event->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->event->date->format('M d, Y') }} • by {{ $booking->event->user->name }}</p>
                                </div>
                                @if($booking->event->isPast())
                                    <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full mr-4">{{ __('Completed') }}</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full mr-4">{{ __('Upcoming') }}</span>
                                @endif
                                <a href="{{ route('events.show', $booking->event) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">→</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
