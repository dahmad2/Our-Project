<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">All Users</h3>

                <table class="min-w-full border border-gray-300 text-center">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Role</th>
                            <th class="border px-4 py-2">Approved</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->id }}</td>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $user->is_approved ? 'Yes' : 'No' }}
                                </td>
                                <td class="border px-4 py-2">
                                    @if (!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:underline">Approve</button>
                                        </form>

                                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Approved</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($users->isEmpty())
                    <p class="mt-4 text-gray-500">No users found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
