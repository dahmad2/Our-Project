<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 uppercase text-xs text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Approval</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-2">
                                    @if ($user->is_approved)
                                        <span class="text-green-600 font-semibold">Approved</span>
                                    @else
                                        <span class="text-red-500 font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex space-x-2">
                                    @if (!$user->is_approved)
                                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 italic text-xs">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
