<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Event Title') }} <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                            placeholder="Enter event title"
                            required
                        />
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Description') }}
                        </label>
                        <textarea 
                            id="description" 
                            name="description"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Enter event description"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Event Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="date" 
                            name="date"
                            value="{{ old('date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror"
                            required
                        />
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div class="mb-6">
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Capacity') }} <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="capacity" 
                            name="capacity"
                            value="{{ old('capacity') }}"
                            min="1"
                            max="10000"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('capacity') border-red-500 @enderror"
                            placeholder="Enter event capacity"
                            required
                        />
                        @error('capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                        >
                            {{ __('Create Event') }}
                        </button>
                        <a 
                            href="{{ route('events.index') }}"
                            class="flex-1 text-center px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition"
                        >
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
