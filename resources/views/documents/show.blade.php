@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Foydalanuvchi hujjatlari</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('user-documents.show', $user->id) }}" class="mb-6 flex space-x-4">
            <!-- Yil tanlash -->
            <select name="year" class="p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <option value="">Yilni tanlang</option>
                @foreach(range(date('Y'), 2000) as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <!-- Oy tanlash -->
            <select name="month" class="p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <option value="">Oyni tanlang</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filterlash</button>
        </form>

        <!-- Documents Table -->
        <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-800">
                <th class="border border-gray-300 dark:border-gray-700 p-2">#</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Hujjat nomi</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Turi</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Yuklangan sana</th>
                <th class="border border-gray-300 dark:border-gray-700 p-2">Amallar</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($user->documents as $index => $document)
                <tr class="border border-gray-300 dark:border-gray-700">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $document->criterion->name ?? 'Noma’lum' }}</td>
                    <td class="p-2">{{ ucfirst($document->type) }}</td>
                    <td class="p-2">{{ $document->created_at->format('Y-m-d') }}</td>
                    <td class="p-2">
                        <a href="{{ asset($document->path) }}" target="_blank" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-700">Ko‘rish</a>
                        <a href="{{ route('download.document', $document->id) }}" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-700">Yuklash</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">Hujjatlar topilmadi.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
