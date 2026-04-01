<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($bookings->count() > 0)
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $booking->event->title }}
                                            </h3>
                                            @if($booking->event->isPast())
                                                <span class="inline-block px-3 py-1 bg-gray-200 text-gray-800 text-xs font-semibold rounded-full">
                                                    {{ __('Past') }}
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-green-200 text-green-800 text-xs font-semibold rounded-full">
                                                    {{ __('Upcoming') }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-gray-600 text-sm mb-3">
                                            {{ Str::limit($booking->event->description, 150) }}
                                        </p>

                                        <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                                </svg>
                                                <span>{{ $booking->event->date->format('M d, Y') }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>by {{ $booking->event->user->name }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                                </svg>
                                                <span>Booked {{ $booking->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-4 flex flex-col gap-2">
                                        <a 
                                            href="{{ route('events.show', $booking->event) }}"
                                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center whitespace-nowrap"
                                        >
                                            {{ __('View Event') }}
                                        </a>
                                        @if(!$booking->event->isPast())
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition whitespace-nowrap w-full"
                                                >
                                                    {{ __('Cancel Booking') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 text-lg mb-4">{{ __('You have not booked any events yet.') }}</p>
                    <a href="{{ route('events.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        {{ __('Browse Events') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
