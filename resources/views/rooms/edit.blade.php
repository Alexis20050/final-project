<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Room: {{ $room->room_number }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('rooms.update', $room) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Room Number --}}
                        <div>
                            <x-input-label for="room_number" :value="__('Room Number')" />
                            <x-text-input id="room_number" class="block mt-1 w-full" type="text" name="room_number" :value="old('room_number', $room->room_number)" required autofocus />
                            <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                        </div>

                        {{-- Room Type --}}
                        <div>
                            <x-input-label for="type" :value="__('Room Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="single" {{ old('type', $room->type) == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="double" {{ old('type', $room->type) == 'double' ? 'selected' : '' }}>Double</option>
                                <option value="dormitory" {{ old('type', $room->type) == 'dormitory' ? 'selected' : '' }}>Dormitory</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        {{-- Capacity --}}
                        <div>
                            <x-input-label for="capacity" :value="__('Capacity')" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity', $room->capacity)" required />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        {{-- Price per Month --}}
                        <div>
                            <x-input-label for="price_per_month" :value="__('Price per Month (₱)')" />
                            <x-text-input id="price_per_month" class="block mt-1 w-full" type="number" step="0.01" name="price_per_month" :value="old('price_per_month', $room->price_per_month)" required />
                            <x-input-error :messages="$errors->get('price_per_month')" class="mt-2" />
                        </div>

                        {{-- Status --}}
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <x-input-label for="image" :value="__('Room Image')" />
                            @if($room->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="Current image" style="max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
                                    <p class="text-sm text-gray-500 mt-1">Current image – upload a new one to replace.</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Optional. Max 2MB, JPG/PNG/WEBP. Leave empty to keep current image.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">Cancel</a>
                            <x-primary-button>Update Room</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>