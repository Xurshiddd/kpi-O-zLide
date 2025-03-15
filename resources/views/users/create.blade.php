@extends('layouts.admin')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif
            @if ($message = Session::get('error'))
                <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                    <p>{{ $message }}</p>
                </div>
            @endif

        <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md inline-block mb-4">
            Ortga
        </a>

        <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Foydalanuvchi qo‘shish</h2>
            @if($errors->any())
                @foreach($errors->all() as $msg)
                    <span class="text-red-500">{{ $msg }}</span>
                @endforeach
            @endif
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ism</label>
                    <input name="first_name" type="text" required placeholder="Ismingizni kiriting"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Familya</label>
                    <input name="last_name" type="text" placeholder="Familyangizni kiriting"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Lavozim</label>
                    <input name="position" type="text" placeholder="Lavozimingizni kiriting"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                    <input type="tel" id="phone" name="phone" maxlength="9" placeholder="99 123 45 67"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" type="email" placeholder="Emailingizni kiriting"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Bo'lim</label>
                    <select name="department_id" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200">
                        <option disabled selected>Bo'limni tanlang</option>
                        @foreach(App\Models\Department::all() as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Viloyat</label>
                    <select name="region_id" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200">
                        <option disabled selected>Viloyatni tanlang</option>
                        @foreach(App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Manzil</label>
                    <textarea name="address" placeholder="Manzilingizni kiriting"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Parol</label>
                    <input name="password" type="password" required placeholder="Parol kiriting"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                    <select name="roles[]" multiple="multiple"
                            class="select2 w-full p-2 border rounded-md focus:ring focus:ring-blue-200">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Foto</label>
                    <input id="photo" name="photo" type="file" accept="image/*"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    <!-- Rasmni ko‘rsatish -->
                    <div class="mt-4">
                        <img id="preview" src="" alt="Tanlangan rasm bu yerda chiqadi"
                             class="hidden w-32 h-32 object-cover rounded-lg border border-gray-300">
                    </div>
                </div>

                <button type="submit" class="md:col-span-2 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                    Saqlash
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('preview');
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            initialCountry: "uz",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/utils.js"
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
