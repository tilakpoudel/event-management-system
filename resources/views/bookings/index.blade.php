<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('🎫 My Bookings') }}
            </h2>
            <p class="text-gray-600 text-sm mt-2">{{ __('Manage your event reservations') }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($bookings->count() > 0)
                <!-- Success Message -->
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

                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                                <!-- Event Info -->
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        <!-- Event Status Badge -->
                                        <div class="flex-shrink-0">
                                            @if($booking->event->isPast())
                                                <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 0a10 10 0 110 20 10 10 0 010-20z"></path>
                                                    </svg>
                                                    {{ __('Completed') }}
                                                </div>
                                            @else
                                                <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                                    {{ __('Upcoming') }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Event Details -->
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                                {{ $booking->event->title }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                {{ $booking->event->description ?: 'No description provided' }}
                                            </p>

                                            <!-- Event Meta -->
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                                <div class="flex items-center text-gray-700">
                                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="font-semibold">{{ $booking->event->date->format('M d, Y') }}</span>
                                                </div>

                                                <div class="flex items-center text-gray-700">
                                                    <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="font-semibold">{{ $booking->event->user->name }}</span>
                                                </div>

                                                <div class="flex items-center text-gray-700">
                                                    <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z"></path>
                                                    </svg>
                                                    <span class="font-semibold">{{ $booking->event->capacity - $booking->event->bookings()->count() }} left</span>
                                                </div>

                                                <div class="flex items-center text-gray-700">
                                                    <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-xs">{{ $booking->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                                    <a 
                                        href="{{ route('events.show', $booking->event) }}"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg text-center transform hover:scale-105"
                                    >
                                        {{ __('View Event') }}
                                    </a>
                                    @if(!$booking->event->isPast())
                                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your booking?');" class="w-full sm:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="w-full px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition shadow-md hover:shadow-lg"
                                            >
                                                {{ __('Cancel') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg text-center">
                                            {{ __('Completed') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $bookings->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-xl p-12 text-center border-2 border-dashed border-gray-300">
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg font-bold mb-2">{{ __('No bookings yet') }}</p>
                    <p class="text-gray-500 text-sm mb-8">{{ __('You haven\'t booked any events. Start exploring and book an event!') }}</p>
                    <a href="{{ route('events.index') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl">
                        {{ __('Browse Events') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
