@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    ✖
                </button>
            </div>
        @endif
            @if(session('error'))
                <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                        ✖
                    </button>
                </div>
            @endif
        <h2 class="text-2xl font-semibold mb-4  dark:bg-dark text-black dark:text-white bg-white-300">Foydalanuvchilar
            ro'yxati</h2>

        <!-- 🔹 Filter form -->
        <form method="GET" action="{{ route('documents.index') }}"
              class="flex space-x-4 mb-6 bg-white p-4 shadow-md rounded-lg dark:bg-gray-700 text-black dark:text-white bg-white">
            <!-- Kategoriya filtri -->
            <select name="category_id" id="categoryFilter"
                    class="p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 text-black dark:text-white bg-white">
                <option value="">Kategoriya tanlang</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <!-- Departament filtri -->
            <select name="department_id" id="departmentFilter"
                    class="dark:bg-gray-700 text-black dark:text-white bg-white p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" {{ request('category_id') ? '' : 'disabled' }}>
                <option value="">Departament tanlang</option>
                @foreach($departments as $department)
                    <option
                        value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>

            <!-- Foydalanuvchi filtri -->
            <input type="text" name="search" placeholder="Ism yoki familiya" value="{{ request('search') }}"
                   class="p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 text-black dark:text-white bg-white">

            <!-- Submit tugmasi -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all">
                Filterlash
            </button>
        </form>

        <!-- 🔹 Foydalanuvchilar jadvali -->
        <div
            class="overflow-x-auto bg-white shadow-md rounded-lg p-4 dark:bg-gray-700 text-black dark:text-white bg-white">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="text-gray-600 dark:bg-gray-700 dark:text-white bg-white">
                <tr>
                    <th class="p-3 border border-gray-300">#</th>
                    <th class="p-3 border border-gray-300">Ism</th>
                    <th class="p-3 border border-gray-300">Familiya</th>
                    <th class="p-3 border border-gray-300">Bo'lim</th>
                    <th class="p-3 border border-gray-300">Umumiy Ball</th>
                    <th class="p-3 border border-gray-300">Amallar</th>
                </tr>
                </thead>
                <tbody class="text-gray-700">
                @forelse($users as $index => $user)
                    <tr class="border-b border-gray-300 hover:bg-gray-100 transition dark:bg-gray-700 text-black dark:text-white bg-white">
                        <td class="p-3 border border-gray-300 text-center">{{ $index + 1 }}</td>
                        <td class="p-3 border border-gray-300 text-center">{{ $user->first_name }}</td>
                        <td class="p-3 border border-gray-300 text-center">{{ $user->last_name }}</td>
                        <td class="p-3 border border-gray-300 text-center">{{ $user->department->name }}</td>
                        <td class="p-3 border border-gray-300 text-center">{{ $user->documents->sum('score') ? $user->documents->sum('score') : 'Hujjatlar yo\'q' }}</td>
                        <td class="p-3 border border-gray-300 flex justify-around">
                            <a href="{{ route('user-documents.show', $user->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                Kirish
                            </a>
                            @if($user->documents->sum('score'))
                            <form action="{{ route('document.score') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                    Tasdiqlash
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-500">Foydalanuvchilar topilmadi.</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- 🔹 JavaScript -->
    <script>
        document.getElementById("categoryFilter").addEventListener("change", function () {
            let categoryId = this.value;
            let departmentFilter = document.getElementById("departmentFilter");

            departmentFilter.innerHTML = '<option value="">Departament tanlang</option>';
            departmentFilter.disabled = true;

            if (categoryId) {
                fetch(`/admin/departments-by-category/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(dept => {
                            departmentFilter.innerHTML += `<option value="${dept.id}">${dept.name}</option>`;
                        });
                        departmentFilter.disabled = false;
                    });
            }
        });
    </script>
@endsection
