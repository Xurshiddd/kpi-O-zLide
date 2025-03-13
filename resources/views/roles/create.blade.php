@extends('layouts.admin')

@section('content')
    <div class="container">
        <a href="/admin/roles"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 mb-4 inline-block">
            ← Ortga
        </a>
        <div class=" bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4">Roles Create</h2>
            <form role="form" action="{{ $role->id ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
                @csrf
                @if($role->id)
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                           name="name"
                           type="text"
                           value="{{ old('name', $role->name) }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Permissions</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($permissions as $permission)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       class="form-checkbox text-blue-500"
                                    {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                                <span>{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                    Save
                </button>
            </form>
        </div>
    </div>
@endsection
