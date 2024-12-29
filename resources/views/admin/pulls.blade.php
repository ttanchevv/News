@extends('layouts.admin')

@section('title', 'Manage Polls')

@section('content')
    <div class="bg-white rounded-2xl p-6 shadow-2xl">
        <h1 class="text-2xl font-bold mb-6">Manage Polls</h1>

        <!-- Form to create new poll -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Create New Poll</h2>
            <form action="{{ route('createPulls') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Poll Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Полета за опции -->
                <div id="options-container" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Options</label>
                    <div class="option mb-2">
                        <input type="text" name="options[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Option 1" required>
                        <button type="button" class="remove-option text-red-500 text-sm">Remove</button>
                    </div>
                    <div class="option mb-2">
                        <input type="text" name="options[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Option 2" required>
                        <button type="button" class="remove-option text-red-500 text-sm">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-option" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add Option</button>

                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 mt-4">Create Poll</button>
            </form>
        </div>

        <!-- Polls List -->
        @if($pulls->isEmpty())
            <p class="text-red-700 text-center font-extrabold">No polls available. Please create one above.</p>
        @else
            <div>
                <h2 class="text-xl font-semibold mb-4">Existing Polls</h2>
                <table class="w-full bg-white border-collapse rounded-2xl shadow-2xl">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Title</th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-left">Start Date</th>
                        <th class="border px-4 py-2 text-left">End Date</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pulls as $poll)
                        <tr>
                            <td class="border px-4 py-2">{{ $poll->id }}</td>
                            <td class="border px-4 py-2">{{ $poll->title }}</td>
                            <td class="border px-4 py-2">{{ $poll->description }}</td>
                            <td class="border px-4 py-2">{{ $poll->start_date }}</td>
                            <td class="border px-4 py-2">{{ $poll->end_date }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('editPulls', ['id' => $poll->id]) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('deletePulls', ['id' => $poll->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addOptionButton = document.getElementById('add-option');
        const optionsContainer = document.getElementById('options-container');

        addOptionButton.addEventListener('click', function () {
            const optionCount = optionsContainer.querySelectorAll('.option').length + 1;

            // Създаваме ново поле за опция
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('option', 'mb-2');
            optionDiv.innerHTML = `
                <input type="text" name="options[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    placeholder="Option ${optionCount}" required>
                <button type="button" class="remove-option text-red-500 text-sm">Remove</button>
            `;

            // Добавяме новото поле към контейнера
            optionsContainer.appendChild(optionDiv);
        });

        // Обработване на премахване на опция
        optionsContainer.addEventListener('click', function (event) {
            if (event.target && event.target.classList.contains('remove-option')) {
                // Премахваме родителския div, който съдържа полето
                event.target.parentElement.remove();
            }
        });
    });
</script>
