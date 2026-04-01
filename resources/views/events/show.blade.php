<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900">{{ $event->title }}</h2>
                <p class="text-gray-600 text-m mt-2">by <strong>{{ $event->user->name }}</strong></p>
            </div>
            @if(auth()->id() === $event->user_id)
                <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold rounded-lg hover:from-amber-600 hover:to-amber-700 transition shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Event') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Event Details Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            {{ __('Event Details') }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            <!-- Date -->
                            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-2">{{ __('Event Date') }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $event->date->format('F d, Y') }}</p>
                                <p class="text-sm text-blue-600 mt-2">{{ $event->date->format('l') }}</p>
                            </div>

                            <!-- Capacity -->
                            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                                <p class="text-xs font-bold text-green-700 uppercase tracking-wide mb-2">{{ __('Total Capacity') }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $event->capacity }}</p>
                                <p class="text-sm text-green-600 mt-2">{{ __('seats available') }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($event->description)
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-4">{{ __('Description') }}</h4>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Attendees List -->
                    @if($event->bookings()->count() > 0)
                        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 7H7v6h6V7z"></path>
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2V2a1 1 0 112 0v1a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2v1a1 1 0 11-2 0v-1h-2v1a1 1 0 11-2 0v-1h-2a2 2 0 01-2-2v-2H3a1 1 0 110-2h1V9H3a1 1 0 010-2h1V5a2 2 0 012-2v-1a1 1 0 010-2h2V2z"></path>
                                    </svg>
                                </div>
                                {{ __('Attendees') }} <span class="ml-2 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">{{ $event->bookings()->count() }}</span>
                            </h3>

                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($event->bookings()->with('user')->latest()->get() as $booking)
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-100 hover:shadow-md transition">
                                        <div class="flex items-center flex-1">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <p class="font-bold text-gray-900">{{ $booking->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-bold text-gray-600 uppercase">{{ __('Booked') }}</p>
                                            <p class="text-sm text-gray-700">{{ $booking->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar: Booking Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 sticky top-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Booking Info') }}</h3>

                        <!-- Availability Section -->
                        <div class="mb-8 p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-2 border-blue-200">
                            <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-3">{{ __('Availability') }}</p>
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-3xl font-bold text-gray-900">{{ $availableSeats }}</span>
                                    <span class="text-sm text-gray-600">of {{ $event->capacity }} seats</span>
                                </div>
                                <div class="w-full bg-gray-300 rounded-full h-3 overflow-hidden">
                                    <div 
                                        class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300"
                                        style="width: {{ ($bookedCount / $event->capacity) * 100 }}%"
                                    ></div>
                                </div>
                            </div>
                            <p class="text-xs text-blue-700">
                                <strong>{{ $bookedCount }}</strong> {{ __('people have booked') }}
                            </p>
                        </div>

                        <!-- Booking Status -->
                        @auth
                            @if($isUserBooked)
                                <div class="mb-6 p-4 bg-green-50 border-2 border-green-300 rounded-xl">
                                    <div class="flex items-center text-green-700 font-bold mb-2">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('You are booked!') }}
                                    </div>
                                    <p class="text-sm text-green-700">{{ __('Check your email for confirmation details') }}</p>

                                    <form action="{{ route('bookings.destroy', $event->bookings()->where('user_id', auth()->id())->first()) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your booking?')" class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="w-full px-4 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition shadow-md hover:shadow-lg"
                                        >
                                            {{ __('Cancel Booking') }}
                                        </button>
                                    </form>
                                </div>
                            @elseif($event->isFullyBooked())
                                <div class="p-6 bg-red-50 border-2 border-red-300 rounded-xl text-center">
                                    <svg class="w-12 h-12 text-red-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-700 font-bold text-lg">{{ __('Event is Fully Booked') }}</p>
                                    <p class="text-red-600 text-sm mt-2">{{ __('Sorry, no seats available. You can try another event.') }}</p>
                                </div>
                            @else
                                <form action="{{ route('bookings.store') }}" method="POST" class="mb-6">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <button 
                                        type="submit"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ __('Book This Event') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="p-6 bg-blue-50 border-2 border-blue-300 rounded-xl text-center">
                                <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <p class="text-blue-700 font-bold mb-4">{{ __('Sign in to book') }}</p>
                                <a href="{{ route('login') }}" class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg text-center">
                                    {{ __('Log In / Register') }}
                                </a>
                            </div>
                        @endauth

                        <!-- Info Box -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600 mb-3">
                                <strong>{{ __('Organizer:') }}</strong> {{ $event->user->name }}
                            </p>
                            @if($event->isPast())
                                <div class="p-3 bg-gray-100 rounded text-center">
                                    <p class="text-xs font-bold text-gray-700">{{ __('This event has passed') }}</p>
                                </div>
                            @else
                                <p class="text-xs text-gray-600">
                                    <strong>{{ __('Starts in:') }}</strong> {{ $event->date->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
