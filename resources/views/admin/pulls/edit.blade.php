@extends('layouts.admin')

@section('title', 'Edit Poll')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Poll</h1>

        <form action="{{ route('updatePoll', ['id' => $pullByID->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $pullByID->title) }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="6" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $pullByID->description) }}</textarea>
            </div>

            <!-- Options -->
            <div class="mb-4">
                <label for="options" class="block text-gray-700 font-medium mb-2">Options</label>
                <div id="options-container">
                    @foreach($pullOption as $index => $option)
                        <div class="mb-4" id="option-{{ $index }}">
                            <input type="text" name="options[{{ $index }}]" value="{{ old('options.' . $index, $option->option) }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Option {{ $index + 1 }}">
                            <button type="button" class="text-red-500 mt-2" onclick="removeOption({{ $index }})">Remove</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-option" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 mt-4">
                    Add Option
                </button>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                Update Poll
            </button>
        </form>
    </div>

    <script>
        let optionIndex = {{ count($pullOption) }};

        // Добавяне на нова опция
        document.getElementById('add-option').addEventListener('click', function() {
            const container = document.getElementById('options-container');
            const newOption = document.createElement('div');
            newOption.classList.add('mb-4');
            newOption.id = 'option-' + optionIndex;
            newOption.innerHTML = `
                <input type="text" name="options[${optionIndex}]" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Option ${optionIndex + 1}">
                <button type="button" class="text-red-500 mt-2" onclick="removeOption(${optionIndex})">Remove</button>
            `;
            container.appendChild(newOption);
            optionIndex++;
        });

        // Премахване на опция
        function removeOption(index) {
            const option = document.getElementById('option-' + index);
            option.remove();
        }
    </script>
@endsection
