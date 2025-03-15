@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md inline-block mb-4">
            Ortga
        </a>

        <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Foydalanuvchini tahrirlash</h2>

            @if($errors->any())
                @foreach($errors->all() as $msg)
                    <span class="text-red-500">{{ $msg }}</span>
                @endforeach
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ism</label>
                    <input name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Familya</label>
                    <input name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Lavozim</label>
                    <input name="position" type="text" value="{{ old('position', $user->position) }}"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="9"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Bo'lim</label>
                    <select name="department_id" class="w-full p-2 border rounded-md">
                        <option disabled>Bo'limni tanlang</option>
                        @foreach(App\Models\Department::all() as $department)
                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Viloyat</label>
                    <select name="region_id" class="w-full p-2 border rounded-md">
                        <option disabled>Viloyatni tanlang</option>
                        @foreach(App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}" {{ $user->region_id == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Manzil</label>
                    <textarea name="address"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">{{ old('address', $user->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Yangi Parol (Agar o'zgartirmoqchi bo'lsangiz)</label>
                    <input name="password" type="password"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                    <select name="roles[]" multiple="multiple" class="select2 w-full p-2 border rounded-md">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Yangi Foto</label>
                    <input id="photo" name="photo" type="file" accept="image/*"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">

                    <div class="mt-4">
                        <img id="preview" src="{{ $user->photo ? asset($user->photo) : asset('assets/images/profile/user-1.jpg') }}"
                             alt="Tanlangan rasm bu yerda chiqadi"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                    </div>
                </div>

                <button type="submit" class="md:col-span-2 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                    Yangilash
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
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
