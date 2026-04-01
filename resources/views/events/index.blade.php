<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Discover Events') }}
                </h2>
                <p class="text-gray-600 text-sm mt-2">{{ __('Browse and book exciting events near you') }}</p>
            </div>
            @auth
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Create Event') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->count() > 0)
                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($events as $event)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <!-- Event Header with Date Badge -->
                            <div class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden">
                                <div class="absolute inset-0 opacity-10 bg-pattern"></div>
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-lg px-4 py-2 text-white font-bold text-sm">
                                    {{ $event->date->format('M d') }}
                                </div>
                                <div class="absolute inset-0 flex items-end">
                                    <div class="w-full h-32 bg-gradient-to-t from-black/30 to-transparent"></div>
                                </div>
                            </div>

                            <!-- Event Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ $event->description ?: 'No description provided' }}
                                </p>

                                <!-- Event Meta Information -->
                                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                                    <!-- Date & Time -->
                                    <div class="flex items-center text-gray-700">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="ml-3 font-medium">{{ $event->date->format('F d, Y') }}</span>
                                    </div>

                                    <!-- Capacity -->
                                    <div class="flex items-center text-gray-700">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 7H7v6h6V7z"></path>
                                                <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2V2a1 1 0 112 0v1a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2v1a1 1 0 11-2 0v-1h-2v1a1 1 0 11-2 0v-1h-2a2 2 0 01-2-2v-2H3a1 1 0 110-2h1V9H3a1 1 0 010-2h1V5a2 2 0 012-2v-1a1 1 0 010-2h2V2z"></path>
                                            </svg>
                                        </div>
                                        <span class="ml-3 font-medium">
                                            <span class="font-bold text-gray-900">{{ $event->bookings()->count() }}</span>/{{ $event->capacity }}
                                            <span class="text-gray-500 text-sm">seats</span>
                                        </span>
                                    </div>

                                    <!-- Organizer -->
                                    <div class="flex items-center text-gray-700">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100">
                                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="ml-3 font-medium">{{ $event->user->name }}</span>
                                    </div>
                                </div>

                                <!-- Availability Bar -->
                                <div class="mb-6">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Availability</span>
                                        <span class="text-xs font-bold text-gray-600">{{ $event->capacity - $event->bookings()->count() }} left</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div 
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-300"
                                            style="width: {{ ($event->bookings()->count() / $event->capacity) * 100 }}%"
                                        ></div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="{{ route('events.show', $event) }}" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg text-center transform hover:scale-105">
                                        {{ __('View Details') }}
                                    </a>
                                    @if(auth()->id() === $event->user_id)
                                        <a href="{{ route('events.edit', $event) }}" class="flex-1 px-4 py-3 bg-gray-200 text-gray-900 font-bold rounded-lg hover:bg-gray-300 transition text-center transform hover:scale-105">
                                            {{ __('Manage') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    {{ $events->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-xl p-12 text-center border-2 border-dashed border-gray-300">
                    <div class="mb-4">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg mb-2">{{ __('No events available yet') }}</p>
                    <p class="text-gray-500 text-sm mb-8">{{ __('Check back soon or create the first event on our platform') }}</p>
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl">
                            {{ __('Create First Event') }}
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
