@extends('layouts.admin')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ isset($department) ? 'Bo\'limni Tahrirlash' : 'Yangi Bo\'lim Qo‘shish' }}
        </h2>

        <form action="{{ isset($department) ? route('departments.update', $department->id) : route('departments.store') }}"
              method="POST" class="space-y-4">
            @csrf
            @if(isset($department))
                @method('PUT')
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200">
                    @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" @selected(isset($department) && $department->category_id == $category->id) class="px-3 py-2 text-gray-700 bg-white hover:bg-gray-100">
                            {{ $category->name }}
                        </option>

                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomi</label>
                <input type="text" name="name" value="{{ isset($department->name) ? $department->name : ' ' }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div>
                <button
                    class=" bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded-md transition duration-200">Saqlash</button>
                <a href="{{ route('departments.index') }}" role="button" class="px-6  bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-md transition duration-200">Ortga</a>
            </div>
        </form>
    </div>
@endsection
