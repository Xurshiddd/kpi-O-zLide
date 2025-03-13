@extends('layouts.admin')

@section('content')
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Categories</h2>
            <a href="{{ route('categories.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                Qo'shish
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Nomi</th>
                    <th class="border border-gray-300 px-4 py-2">Harakat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                        <td class="border border-gray-300 px-4 py-2 flex space-x-2 flex justify-around">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fa fa-trash"></i>
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
