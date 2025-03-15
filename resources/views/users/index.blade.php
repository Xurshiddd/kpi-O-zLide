@extends('layouts.admin')
@section('content')
    <a href="/admin/users/create"
       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-200 w-[150px]">
        + Qo'shish
    </a>
    <div class="mt-4">
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
                        <th class="px-6 py-3">Photo</th>
                        <th class="px-6 py-3">(F.I)</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Roli</th>
                        <th class="px-6 py-3 text-center">Xarakat</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($users as $key => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $key + 1 }}</td>
                            <td>
                                <img src="{{ $user->photo ? asset($user->photo) : asset('assets/images/profile/user-1.jpg') }}"
                                     class="m-4 object-cover w-9 h-9 rounded-full">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->first_name . ' '. $user->last_name }}</td>
                            <td class="px-6 py-4">{{ $user->phone }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button onclick="showUserModal({{ $user }})"
                                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded">
                                    Show
                                </button>
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Foydalanuvchini o‘chirishni xohlaysizmi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    <!-- User Details Modal -->
    <div id="userModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">
            <h2 class="text-xl font-semibold text-gray-800 text-center">Foydalanuvchi Tafsilotlari</h2>
            <div class="mt-4 text-center">
                <img id="modalPhoto" class="w-24 h-24 rounded-full mx-auto object-cover border">
                <p class="mt-2 text-lg font-semibold" id="modalName"></p>
                <p class="text-gray-700 text-sm" id="modalPosition"></p>
            </div>
            <div class="mt-4 space-y-2 text-sm text-gray-700">
                <p><strong>Telefon:</strong> <span id="modalPhone"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Bo‘lim:</strong> <span id="modalDepartment"></span></p>
                <p><strong>Hudud:</strong> <span id="modalRegion"></span></p>
                <p><strong>Manzil:</strong> <span id="modalAddress"></span></p>
                <p><strong>Ro‘yxatdan o‘tgan sana:</strong> <span id="modalCreatedAt"></span></p>
            </div>
            <button onclick="closeModal()" class="mt-4 bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded block mx-auto">
                Yopish
            </button>
        </div>
    </div>

    <script>
        function showUserModal(user) {
            document.getElementById("modalName").innerText = user.first_name + " " + (user.last_name ?? "");
            document.getElementById("modalPhone").innerText = user.phone;
            document.getElementById("modalEmail").innerText = user.email ?? "Email yo‘q";
            document.getElementById("modalPosition").innerText = user.position ?? "Lavozim yo‘q";
            document.getElementById("modalDepartment").innerText = user.department?.name ?? "Bo‘lim yo‘q";
            document.getElementById("modalRegion").innerText = user.region?.name ?? "Hudud yo‘q";
            document.getElementById("modalAddress").innerText = user.address ?? "Manzil yo‘q";
            document.getElementById("modalCreatedAt").innerText = formatDate(user.created_at) ?? "Noma'lum sana";
            document.getElementById("modalPhoto").src = user.photo ? "/"+user.photo : "{{ asset('assets/images/profile/user-1.jpg') }}";

            document.getElementById("userModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("userModal").classList.add("hidden");
        }
        function formatDate(dateString) {
            if (!dateString) return "Noma'lum sana";
            const date = new Date(dateString);
            return date.toISOString().split("T")[0]; // Y-m-d format
        }
    </script>
@endsection
