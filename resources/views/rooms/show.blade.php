<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Room Details: {{ $room->room_number }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Room Number</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $room->room_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Room Type</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ ucfirst($room->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $room->capacity }} person(s)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price per Month</dt>
                            <dd class="mt-1 text-lg text-gray-900">₱{{ number_format($room->price_per_month, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($room->status == 'available') bg-green-100 text-green-800
                                    @elseif($room->status == 'occupied') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-gray-900">{{ $room->created_at->format('F d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-gray-900">{{ $room->updated_at->format('F d, Y h:i A') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 flex items-center justify-end space-x-3">
                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">Back to Rooms</a>
                        
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Edit Room</a>
                                <form method="POST" action="{{ route('rooms.destroy', $room) }}" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">Delete Room</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>