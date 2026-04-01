<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Events') }}
            </h2>
            @auth
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    {{ __('Create Event') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event->description, 100) }}</p>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                        <span>{{ $event->date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v4h8v-4zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.904A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.096z"></path>
                                        </svg>
                                        <span>{{ $event->bookings()->count() }}/{{ $event->capacity }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>by {{ $event->user->name }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('events.show', $event) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                                        {{ __('View') }}
                                    </a>
                                    @if(auth()->id() === $event->user_id)
                                        <a href="{{ route('events.edit', $event) }}" class="flex-1 text-center px-4 py-2 bg-gray-600 text-white font-semibold rounded hover:bg-gray-700 transition">
                                            {{ __('Edit') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <p class="text-gray-600 text-lg mb-4">{{ __('No events available.') }}</p>
                    <a href="{{ route('events.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        {{ __('Create the first event') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
