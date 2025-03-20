@extends('layouts.admin')

@section('content')
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
    @if($errors->any())
        @foreach($errors->all() as $msg)
            <span class="text-red-500">{{ $msg }}</span>
        @endforeach
    @endif
    <div x-data="{ tab: 'info', darkMode: false }" :class="darkMode ? 'bg-gray-600 text-white' : 'bg-white text-gray-900'"
         class="shadow-md rounded-lg p-6 transition-colors duration-300">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Profil</h2>
            <button @click="darkMode = !darkMode"
                    class="p-2 bg-gray-700 text-white rounded-md focus:outline-none">
                <span x-text="darkMode ? '🌞 Light Mode' : '🌙 Dark Mode'"></span>
            </button>
        </div>

        <!-- Tablar -->
        <div class="border-b flex space-x-4">
            <button @click="tab = 'info'" :class="tab === 'info' ? 'border-blue-500 text-blue-400' : 'text-white-400'"
                    class="py-2 px-4 border-b-2 font-medium focus:outline-none">Profil</button>
            <button @click="tab = 'documents'" :class="tab === 'documents' ? 'border-blue-500 text-blue-400' : 'text-white-400'"
                    class="py-2 px-4 border-b-2 font-medium focus:outline-none">Hujjatlar</button>
            <button @click="tab = 'settings'" :class="tab === 'settings' ? 'border-blue-500 text-blue-400' : 'text-white-400'"
                    class="py-2 px-4 border-b-2 font-medium focus:outline-none">Sozlamalar</button>
        </div>

        <!-- Foydalanuvchi Ma'lumotlari -->
        <div x-show="tab === 'info'" class="p-6">
            <div class="flex items-center space-x-6">
                <img src="{{ asset($user->photo) }}" alt="User Photo"
                     class="w-32 h-32 object-cover rounded-full border">
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <p class="text-gray-400">{{ $user->position }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div><strong>Email:</strong> {{ $user->email }}</div>
                <div><strong>Telefon:</strong> {{ $user->phone }}</div>
                <div><strong>Bo'lim:</strong> {{ $user->department->name ?? 'Noma’lum' }}</div>
                <div><strong>Viloyat:</strong> {{ $user->region->name ?? 'Noma’lum' }}</div>
                <div class="md:col-span-2"><strong>Manzil:</strong> {{ $user->address }}</div>
            </div>
        </div>

        <!-- Hujjatlar -->
        <div x-show="tab === 'documents'" class="p-6">
            <h3 class="text-xl font-semibold mb-4">Foydalanuvchi hujjatlari</h3>
            @if($user->documents->isEmpty())
                <p class="text-gray-400">Hujjatlar topilmadi.</p>
            @else
                <ul class="space-y-2">
                    @foreach($user->documents as $document)
                        <li class="flex items-center justify-between p-3 border rounded-md">
                            <span class="text-gray-700" :class="darkMode ? 'bg-gray-600 text-white' : 'bg-white text-gray-900'">{{ $document->criterion->name }}</span>
                            <span class="text-gray-700" :class="darkMode ? 'bg-gray-600 text-white' : 'bg-white text-gray-900'">{{ $document->score }}</span>
                            <a href="{{ asset($document->path) }}" target="_blank"
                               class="text-blue-400 hover:underline">Ko‘rish</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Sozlamalar -->
        <div x-show="tab === 'settings'" class="p-6">
            <h3 class="text-xl font-semibold mb-4">Profilni tahrirlash</h3>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400">Ism</label>
                        <input type="text" name="first_name" value="{{ $user->first_name }}"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                    <div>
                        <label class="block text-gray-400">Familiya</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                    <div>
                        <label class="block text-gray-400">Telefon</label>
                        <input type="text" name="phone" value="{{ $user->phone }}"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                    <div>
                        <label class="block text-gray-400">Manzil</label>
                        <input type="text" name="address" value="{{ $user->address }}"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-400">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-400">Parol</label>
                        <input type="password" name="password"
                               class="w-full p-2 border rounded-md bg-gray-800 text-white" placeholder="Yangi parol">
                    </div>
                    <div>
                        <label class="block text-gray-400">Viloyat</label>
                        <select name="region_id" class="w-full p-2 border rounded-md bg-gray-800 text-white">
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" @if($user->region_id == $region->id) selected @endif>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-400">Profil rasmi</label>
                        <input type="file" name="photo" class="w-full p-2 border rounded-md bg-gray-800 text-white">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
