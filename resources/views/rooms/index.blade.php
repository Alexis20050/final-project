<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Room List</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>Room No.</th><th>Type</th><th>Capacity</th><th>Price/Month</th><th>Status</th>
                                @auth @if(auth()->user()->role === 'admin') <th>Actions</th> @endif @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ ucfirst($room->type) }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>₱{{ number_format($room->price_per_month, 2) }}</td>
                                <td>{{ ucfirst($room->status) }}</td>
                                @auth @if(auth()->user()->role === 'admin')
                                <td class="flex space-x-2">
                                    <a href="{{ route('rooms.edit', $room) }}" class="text-indigo-600">Edit</a>
                                    <form method="POST" action="{{ route('rooms.destroy', $room) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600">Delete</button>
                                    </form>
                                </td>
                                @endif @endauth
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>