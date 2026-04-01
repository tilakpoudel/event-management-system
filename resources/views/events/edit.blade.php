<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            {{ __('✏️ Edit Event') }}
        </h2>
        <p class="text-gray-600 text-sm mt-2">{{ __('Update event details and manage bookings') }}</p>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-900 mb-3">
                            {{ __('Event Title') }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title"
                            value="{{ old('title', $event->title) }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @error('title') border-red-500 @enderror transition"
                            placeholder="Enter event title"
                            required
                        />
                        @error('title')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-900 mb-3">
                            {{ __('Description') }}
                        </label>
                        <textarea 
                            id="description" 
                            name="description"
                            rows="5"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('description') border-red-500 @enderror transition resize-none"
                            placeholder="Enter event description"
                        >{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-bold text-gray-900 mb-3">
                                {{ __('Event Date') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                name="date"
                                value="{{ old('date', $event->date->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 @error('date') border-red-500 @enderror transition"
                                required
                            />
                            @error('date')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-sm font-bold text-gray-900 mb-3">
                                {{ __('Capacity') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="capacity" 
                                name="capacity"
                                value="{{ old('capacity', $event->capacity) }}"
                                min="1"
                                max="10000"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 @error('capacity') border-red-500 @enderror transition"
                                placeholder="Enter event capacity"
                                required
                            />
                            @error('capacity')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button 
                            type="submit"
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Update Event') }}
                        </button>
                        <a 
                            href="{{ route('events.show', $event) }}"
                            class="flex-1 text-center px-6 py-4 bg-gray-100 text-gray-900 font-bold rounded-xl hover:bg-gray-200 transition border-2 border-gray-300"
                        >
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>

                <!-- Delete Section -->
                <div class="mt-12 pt-12 border-t-2 border-red-200">
                    <h3 class="text-lg font-bold text-red-600 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414l-3.85 3.85-1.414-1.415a1 1 0 00-1.414 1.414l2.828 2.829a1 1 0 001.414 0l5.657-5.657z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('🚨 Danger Zone') }}
                    </h3>
                    <p class="text-red-600 text-sm mb-4">{{ __('Once deleted, this event and all its bookings cannot be recovered.') }}</p>
                    <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg hover:shadow-xl flex items-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Delete Event') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
