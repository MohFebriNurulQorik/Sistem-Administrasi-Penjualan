<x-app-layout>
    <x-slot name="header">Users</x-slot>

    <div class="bg-white rounded-2xl p-6 border border-slate-100">
        <div class="flex justify-between mb-4">
            <h2 class="font-bold text-lg">User List</h2>
            <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl">
                + Add User
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="py-2">{{ $user->name }}</td>
                    <td>{{ $user->company_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-center space-x-2">
                        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>