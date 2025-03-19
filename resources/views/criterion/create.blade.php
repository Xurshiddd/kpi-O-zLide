@extends('layouts.admin')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-700 text-black dark:text-white">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ isset($criterion) ? 'Mezonni Tahrirlash' : 'Yangi Mezon Qo‘shish' }}
        </h2>

        <form action="{{ isset($criterion) ? route('criterion.update', $criterion->id) : route('criterion.store') }}"
              method="POST" class="space-y-4">
            @csrf
            @if(isset($criterion))
                @method('PUT')
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Bo'lim</label>
                <select name="department_id" id="department" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200 dark:bg-gray-700 text-black dark:text-white">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected(isset($criterion) && $criterion->department_id == $department->id) class="px-3 py-2 text-gray-700 bg-white hover:bg-gray-100">
                            {{ $department->name }}
                        </option>

                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomi</label>
                <input type="text" name="name" value="{{ isset($criterion->name) ? $criterion->name : ' ' }}"
                       class="dark:bg-gray-700 text-black dark:text-white mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ball</label>
                <input type="number" name="score" value="{{ isset($criterion->score) ? $criterion->score : ' ' }}"
                       class="mt-1 dark:bg-gray-700 text-black dark:text-white block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div>
                <button
                    class=" bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded-md transition duration-200">Saqlash</button>
                <a href="{{ route('criterion.index') }}" role="button" class="px-6  bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-md transition duration-200">Ortga</a>
            </div>
        </form>
    </div>
@endsection
