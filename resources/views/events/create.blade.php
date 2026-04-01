<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            {{ __('🎉 Create New Event') }}
        </h2>
        <p class="text-gray-600 text-sm mt-2">{{ __('Share your amazing event with the community') }}</p>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                <form action="{{ route('events.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                            <span class="inline-block w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold flex items-center justify-center mr-2">1</span>
                            {{ __('Event Title') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @error('title') border-red-500 @enderror transition"
                            placeholder="e.g., Tech Conference 2024"
                            required
                        />
                        @error('title')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414l-3.85 3.85-1.414-1.415a1 1 0 00-1.414 1.414l2.828 2.829a1 1 0 001.414 0l5.657-5.657z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                            <span class="inline-block w-6 h-6 rounded-full bg-purple-100 text-purple-600 text-xs font-bold flex items-center justify-center mr-2">2</span>
                            {{ __('Description') }}
                            <span class="text-gray-400 text-xs ml-2">(Optional)</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description"
                            rows="5"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('description') border-red-500 @enderror transition resize-none"
                            placeholder="Tell people about your event... What to expect, activities, food & drinks, dress code, etc."
                        >{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">{{ __('Make it interesting! People love to know what they\'re signing up for.') }}</p>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                                <span class="inline-block w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center mr-2">3</span>
                                {{ __('Event Date') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                name="date"
                                value="{{ old('date') }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 @error('date') border-red-500 @enderror transition"
                                required
                            />
                            @error('date')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                                <span class="inline-block w-6 h-6 rounded-full bg-orange-100 text-orange-600 text-xs font-bold flex items-center justify-center mr-2">4</span>
                                {{ __('Capacity') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="capacity" 
                                name="capacity"
                                value="{{ old('capacity') }}"
                                min="1"
                                max="10000"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 @error('capacity') border-red-500 @enderror transition"
                                placeholder="e.g., 100"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Create Event') }}
                        </button>
                        <a 
                            href="{{ route('events.index') }}"
                            class="flex-1 text-center px-6 py-4 bg-gray-100 text-gray-900 font-bold rounded-xl hover:bg-gray-200 transition border-2 border-gray-300"
                        >
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-12">
                <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13 7H7v6h6V7z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-900">{{ __('Easy to Set Up') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('Fill in basic details and your event is live') }}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 7H7v6h6V7z"></path>
                            </svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-900">{{ __('Manage Easily') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('View attendees and control capacity') }}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-purple-500">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 7H7v6h6V7z"></path>
                            </svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-900">{{ __('Reach People') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600">{{ __('Get your event discovered by attendees') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
