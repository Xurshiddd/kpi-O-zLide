@extends('layouts.admin')

@section('content')
    <div>
        <div class="flex justify-between items-center mb-4 dark:bg-gray-700 text-black dark:text-white bg-white">
            <h2 class="text-xl text-gray-800 bg-white dark:bg-gray-700 dark:text-white">Rollar</h2>
            <a href="/admin/roles/create"
               class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                + Qo'shish
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-700 text-black dark:text-white">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nomi</th>
                    <th class="px-6 py-3">Xarakat</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($roles as $role)
                    <tr class="hover:bg-gray-50 transition dark:bg-gray-700 text-black dark:text-white">
                        <td class="px-6 py-4">{{ $role->id }}</td>
                        <td class="px-6 py-4">{{ $role->name }}</td>
                        <td class="px-6 py-4 flex space-x-4">
                            <a href="{{ route('roles.edit', $role->id) }}"
                               class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                Edit
                            </a>
                            <a href="{{ route('roles.show', $role->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                Show
                            </a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                  onsubmit="return confirm('Rostdan ham o‘chirmoqchimisiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
