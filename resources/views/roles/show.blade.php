@extends('layouts.admin')
@section('content')
    <div class="">
        <a href="/admin/roles"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 mb-4 inline-block">
            ← Ortga
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 ">
            <table class="w-full text-left bg-white dark:bg-gray-700 text-black dark:text-white">
                <tbody>
                <tr class="border-b">
                    <th class="px-6 py-3  w-1/3">ID</th>
                    <td class="px-6 py-3">{{ $role->id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-6 py-3">Nomi</th>
                    <td class="px-6 py-3">{{ $role->name }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3">Permissions</th>
                    <td class="px-6 py-3 flex flex-wrap gap-2">
                        @foreach($role->permissions as $per)
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-sm">
                                {{ $per->name }}
                            </span>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
