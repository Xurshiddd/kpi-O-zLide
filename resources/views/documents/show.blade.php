@extends('layouts.admin')

@section('content')
    <div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
        <a href="{{ route('documents.index') }}" class="px-4 py-2 bg-green-400 text-white rounded-md hover:bg-green-500">Ortga</a>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 mt-3">Foydalanuvchi hujjatlari</h2>
        <!-- Filter Form -->
        <form method="GET" action="{{ route('user-documents.show', $user->id) }}" class="mb-6 flex flex-wrap gap-4">
            <!-- Yil tanlash -->
            <select name="year" class="p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <option value="">Yilni tanlang</option>
                @foreach(range(date('Y'), 2024) as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <!-- Oy tanlash -->
            <select name="month" class="p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <option value="">Oyni tanlang</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <!-- Filtrlash tugmasi -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Filterlash
            </button>

            <!-- Tozalash tugmasi -->
            <a href="{{ route('user-documents.show', $user->id) }}"
               class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
                Tozalash
            </a>
        </form>


        <!-- Documents Table -->
        <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-800">
                <th class="border border-gray-300 dark:border-gray-700 p-2">#</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Hujjat nomi</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Turi</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Yuklangan sana</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Ball</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Amallar</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($user->documents as $index => $document)
                <tr class="border border-gray-300 dark:border-gray-700 text-center">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $document->criterion->name ?? 'Noma’lum' }}</td>
                    <td class="p-2">{{ ucfirst($document->type) }}</td>
                    <td class="p-2">{{ $document->created_at->format('Y-m-d') }}</td>
                    <td class="p-2">{{ $document->score }}</td>
                    <td class="p-2">
                        <a href="{{ asset($document->path) }}" target="_blank" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-700">Ko‘rish</a>
                        <button onclick="openModal({{ $document->id }}, {{ $document->score }}, {{ $document->criterion->score }})"
                                class="ml-2 px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-700">
                            Baholash
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">Hujjatlar topilmadi.</td>
                </tr>
            @endforelse

            </tbody>
        </table>
        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden justify-center items-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Hujjatni Baholash</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>

                <form method="POST" action="{{ route('document.score') }}">
                    @csrf
                    <input type="hidden" name="document_id" id="documentId">
                    <input type="hidden" value="{{ $user->id }}" name="user_id">

                    <div class="mb-4">
                        <label for="score" class="block text-gray-700 dark:text-gray-200 font-medium">Bahoni kiriting:</label>
                        <small id="maxScoreText" class="block text-sm text-gray-500 dark:text-gray-400 mb-1">
                            Maksimal ball: <span id="maxScoreValue"></span>
                        </small>
                        <input type="number" min="0" max="100" id="score" name="score"
                               class="w-full dark:text-red-800 p-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">Bekor qilish</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Baholash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function openModal(documentId, currentScore, maxScore) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('documentId').value = documentId;
            document.getElementById('score').value = currentScore;

            // Max ballni input va small tagga qo'yish
            document.getElementById('score').setAttribute('max', maxScore);
            document.getElementById('maxScoreValue').textContent = maxScore;
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
@endsection
