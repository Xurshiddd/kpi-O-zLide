@extends('layouts.admin')

@section('content')
    <a href="/admin/categories"
       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 w-[10%]">
        Ortga
    </a>
        <div class=" bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">

            <h2 class="text-xl font-semibold mb-4">{{ $category->id ? 'Edit Category' : 'Create Category' }}</h2>

            <form role="form" action="{{ $category->id ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
                @csrf
                @if($category->id)
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                           name="name"
                           type="text"
                           value="{{ old('name', $category->name ?? '') }}">
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                    {{ $category->id ? 'Update' : 'Save' }}
                </button>
            </form>
        </div>
@endsection
