@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Yangi hujjat qo‘shish</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Criteria lar -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Hujjatlar</h3>
                @if(isset($criterion))
                    @foreach($criterion as $criteria)
                        <div class="mb-4 p-3 border rounded-md bg-white shadow-sm">
                            <h4 class="font-semibold text-gray-800 mb-2">{{ $criteria->name }}</h4>

                            <input type="hidden" name="criteria_id[]" value="{{ $criteria->id }}">

                            <div class="flex gap-4 items-center">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type[{{ $criteria->id }}]" value="file" checked
                                           class="form-radio" onchange="toggleInput('{{ $criteria->id }}', 'file')">
                                    <span class="ml-2 text-gray-700">Fayl</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type[{{ $criteria->id }}]" value="link"
                                           class="form-radio" onchange="toggleInput('{{ $criteria->id }}', 'link')">
                                    <span class="ml-2 text-gray-700">Havola</span>
                                </label>
                            </div>

                            <div class="mt-3">
                                <input id="fileInput{{ $criteria->id }}" name="path[{{ $criteria->id }}]" type="file"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                <input id="linkInput{{ $criteria->id }}" name="path[{{ $criteria->id }}]" type="url"
                                       placeholder="Havola kiriting"
                                       class="hidden block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3>Mezonlar mavjud emas</h3>
                @endif
            </div>

            <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                Saqlash
            </button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function toggleInput(criteriaId, type) {
            let fileInput = document.getElementById('fileInput' + criteriaId);
            let linkInput = document.getElementById('linkInput' + criteriaId);

            if (type === 'file') {
                fileInput.classList.remove('hidden');
                linkInput.classList.add('hidden');
                linkInput.value = "";
            } else {
                fileInput.classList.add('hidden');
                linkInput.classList.remove('hidden');
                fileInput.value = "";
            }
        }
    </script>
@endsection
