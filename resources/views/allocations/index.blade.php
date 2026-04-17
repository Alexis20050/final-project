<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Allocations</h1>
                <a href="{{ route('allocations.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ Manual Allocation</a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr><th>Student</th><th>Room</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($allocations as $alloc)
                        <tr>
                            <td>{{ $alloc->user->name }}</td>
                            <td>{{ $alloc->room->room_number }}</td>
                            <td>{{ $alloc->start_date }}</td>
                            <td>{{ $alloc->end_date ?? 'Current' }}</td>
                            <td>{{ ucfirst($alloc->status) }}</td>
                            <td>
                                @if($alloc->status === 'active')
                                    <form method="POST" action="{{ route('allocations.end', $alloc) }}">
                                        @csrf
                                        <button class="text-red-600">End Allocation</button>
                                    </form>
                                @endif
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $allocations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>