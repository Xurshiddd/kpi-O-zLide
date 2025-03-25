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

            {{-- Bo'lim Tanlash --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Bo'lim</label>
                <select name="department_id" id="department"
                        class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200 dark:bg-gray-700 text-black dark:text-white">
                    <option value="">Bo'limni tanlang</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            @selected(isset($criterion) && $criterion->department_id == $department->id)>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- User Tanlash --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Foydalanuvchi</label>
                <select name="user_id" id="user"
                        class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200 dark:bg-gray-700 text-black dark:text-white">
                    <option value="">Foydalanuvchini tanlang (Ixtiyoriy)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomi</label>
                <input type="text" name="name" value="{{ isset($criterion->name) ? $criterion->name : '' }}"
                       class="dark:bg-gray-700 text-black dark:text-white mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ball</label>
                <input type="number" name="score" value="{{ isset($criterion->score) ? $criterion->score : '' }}"
                       class="mt-1 dark:bg-gray-700 text-black dark:text-white block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div>
                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded-md transition duration-200">
                    Saqlash
                </button>
                <a href="{{ route('criterion.index') }}" role="button"
                   class="px-6 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-md transition duration-200">
                    Ortga
                </a>
            </div>
        </form>
    </div>

    {{-- Ajax Qo'shish --}}
    <script>
        document.getElementById('department').addEventListener('change', function () {
            let departmentId = this.value;
            let userSelect = document.getElementById('user');
            userSelect.innerHTML = '<option value="">Foydalanuvchini tanlang (Ixtiyoriy)</option>';

            if (departmentId) {
                fetch(`/admin/departments/${departmentId}/users`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(user => {
                            let option = document.createElement('option');
                            option.value = user.id;
                            option.text = `${user.first_name} ${user.last_name}`;
                            userSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Xatolik yuz berdi:', error));
            }
        });
    </script>
@endsection
