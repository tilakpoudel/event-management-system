<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>
            @if(auth()->id() === $event->user_id)
                <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    {{ __('Edit Event') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Event Details -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Event Information') }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wide">{{ __('Date') }}</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->date->format('F d, Y') }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wide">{{ __('Organizer') }}</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->user->name }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wide">{{ __('Availability') }}</p>
                                <div class="mt-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-lg font-semibold text-gray-900">{{ $bookedCount }}/{{ $event->capacity }}</span>
                                        <span class="text-sm text-gray-600">{{ $availableSeats }} seats available</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div 
                                            class="bg-blue-600 h-2 rounded-full transition-all"
                                            style="width: {{ ($bookedCount / $event->capacity) * 100 }}%"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Booking') }}</h3>
                        
                        @auth
                            @if($isUserBooked)
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-green-800 font-semibold mb-4">{{ __('You have booked this event') }}</p>
                                    <form action="{{ route('bookings.destroy', $event->bookings()->where('user_id', auth()->id())->first()) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
                                            onclick="return confirm('Are you sure you want to cancel your booking?')"
                                        >
                                            {{ __('Cancel Booking') }}
                                        </button>
                                    </form>
                                </div>
                            @elseif($event->isFullyBooked())
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-800 font-semibold">{{ __('This event is fully booked') }}</p>
                                </div>
                            @else
                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <button 
                                        type="submit"
                                        class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition"
                                    >
                                        {{ __('Book This Event') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-blue-800 mb-4">{{ __('Please log in to book this event') }}</p>
                                <a href="{{ route('login') }}" class="w-full block text-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                    {{ __('Log In') }}
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Description -->
                @if($event->description)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Description') }}</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Attendees List -->
            @if($event->bookings()->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Attendees') }} ({{ $event->bookings()->count() }})</h3>
                    <div class="space-y-3">
                        @foreach($event->bookings()->with('user')->get() as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">{{ $booking->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $booking->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
