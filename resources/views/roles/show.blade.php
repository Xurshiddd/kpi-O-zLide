@extends('layouts.admin')
@section('content')
    <div class="container">
        <a href="/admin/roles"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 mb-4 inline-block">
            ← Ortga
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left text-gray-600">
                <tbody>
                <tr class="border-b">
                    <th class="px-6 py-3 bg-gray-100 w-1/3">ID</th>
                    <td class="px-6 py-3">{{ $role->id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-6 py-3 bg-gray-100">Nomi</th>
                    <td class="px-6 py-3">{{ $role->name }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 bg-gray-100">Permissions</th>
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
