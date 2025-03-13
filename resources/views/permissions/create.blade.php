@extends('layouts.admin')
@section('h1')
    Permissions
@endsection
@section('')
@endsection
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ $permission->id ? 'Ruxsatni Tahrirlash' : 'Yangi Ruxsat Qo‘shish' }}
        </h2>

        <form action="{{ $permission->id ? route('permissions.update', $permission->id) : route('permissions.store') }}"
              method="POST" class="space-y-4">
            @csrf
            @if($permission->id)
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomi</label>
                <input type="text" name="name" value="{{ $permission->name }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div>
                <button
                    class=" bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded-md transition duration-200">Saqlash</button>
                <a href="{{ route('permissions.index') }}" role="button" class="px-6  bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-md transition duration-200">Ortga</a>
            </div>
        </form>
    </div>

@endsection
