@extends('layouts.admin')
@section('h1')
    Permissions
@endsection
@section('')
@endsection
@section('content')
    <div class=" bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Permissions</h2>
            <a href="/admin/permissions/create"
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md">
                Qo'shish
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    ✖
                </button>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nomi</th>
                    <th class="px-6 py-3 text-left">Xarakat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissons as $permission)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $permission->id }}</td>
                        <td class="px-6 py-4">{{ $permission->name }}</td>
                        <td class="px-6 py-4 flex justify-center gap-4">
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                Edit
                            </a>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Permissionni o\'chirishni xohlaysizmi?');">
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

        <div class="mt-4">
            {{ $permissons->links('pagination::tailwind') }}
        </div>
    </div>

@endsection
