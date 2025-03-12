@extends('layouts.admin')

@section('content')
    <div class=" bg-white shadow-md rounded-lg p-6">
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md inline-block mb-4">
            Ortga
        </a>

        <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">User Create</h2>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-4 grid gap-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ism</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           name="first_name" type="text" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Familya</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           name="last_name" type="text">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                    <input type="tel" id="phone" name="phone"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           maxlength="9" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           name="password" type="password" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                    <select name="roles[]"
                            class="select2 mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            multiple="multiple">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto</label>
                    <input id="photo" name="photo" type="file" accept="image/*"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    <!-- Rasmni ko‘rsatish uchun div -->
                    <div class="mt-4">
                        <img id="preview" src="" alt="Tanlangan rasm bu yerda chiqadi"
                             class="hidden w-32 h-32 object-cover rounded-lg border border-gray-300">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                    Save
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
