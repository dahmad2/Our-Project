<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <h3 class="text-xl font-bold text-gray-800">Total Users</h3>
                    <p class="text-3xl mt-2 text-blue-600">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <h3 class="text-xl font-bold text-gray-800">Approved Users</h3>
                    <p class="text-3xl mt-2 text-green-600">{{ $approvedUsers }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <h3 class="text-xl font-bold text-gray-800">Pending Users</h3>
                    <p class="text-3xl mt-2 text-red-600">{{ $pendingUsers->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <h3 class="text-xl font-bold text-gray-800">Total Assets</h3>
                    <p class="text-3xl mt-2 text-purple-600">{{ $totalAssets }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Pending Approvals</h3>
                @if ($pendingUsers->count() > 0)
                    <ul class="space-y-2">
                        @foreach ($pendingUsers as $user)
                            <li class="flex justify-between items-center border p-3 rounded-md">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                                        @csrf
                                        <button class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.reject', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Reject</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No pending users at the moment.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
