@extends('layouts.admin')
@section('content')
    <a href="/admin/users/create"
       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 w-[10%]">
        + Qo'shish
    </a>
    <div class="">
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
            <div class="bg-gray-800 text-white px-6 py-3 text-lg font-semibold">
                Users
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">photo</th>
                        <th class="px-6 py-3">(F.I)</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Roli</th>
                        <th class="px-6 py-3 text-center">Xarakat</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($users as $key => $user)
                        <tr class="hover:bg-gray-50 p-3">
                            <td class="px-6 py-4">{{ $key + 1 }}</td>
                            <td><img src="{{ $user->photo ? $user->photo : asset('assets/images/profile/user-1.jpg') }}" class="m-4 object-cover w-9 h-9 rounded-full"></td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->first_name . ' '. $user->last_name }}</td>
                            <td class="px-6 py-4">{{ $user->phone }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-4">
                                <a href="{{ route('users.edit', $user->id) }}" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Foydalanuvchini o\'chirishni xohlaysizmi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

@endsection

