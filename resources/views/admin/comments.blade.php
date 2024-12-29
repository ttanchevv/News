@extends('layouts.admin')

@section('title', 'Manage Comment')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Manage Comments</h1>

        <!-- Comment List -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Existing Comments</h2>
            <table class="w-full bg-white border-collapse shadow-2xl">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">User</th>
                    <th class="border px-4 py-2 text-left">Comment</th>
                    <th class="border px-4 py-2 text-left">News Name</th>
                    <th class="border px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td class="border px-4 py-2">{{ $comment->user->name }}</td> <!-- Assuming user relationship -->
                        <td class="break-words border px-4 py-2" id="comment-{{ $comment->id }}-text">{{ $comment->comment }}</td>
                        <td class="border px-4 py-2">{{ $comment->news->title }}</td>
                        <td class="border px-4 py-2">
                            <!-- Edit Button -->
                            <button class="text-blue-600 hover:underline edit-button" data-comment-id="{{ $comment->id }}">Edit</button>
                            <!-- Delete Button -->
                            <a href="{{ route('comments.delete', $comment->id) }}" class="text-red-500 hover:underline"
                               onclick="event.preventDefault(); document.getElementById('delete-comment-{{ $comment->id }}').submit();">
                                Delete
                            </a>

                            <form id="delete-comment-{{ $comment->id }}" action="{{ route('comments.delete', $comment->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>

                    <!-- The editable row will be inserted here -->
                    <tr id="edit-row-{{ $comment->id }}" class="hidden">
                        <td colspan="3" class="border px-4 py-2">
                            <!-- Edit Form -->
                            <form method="POST" action="{{ route('comments.store', $comment->id) }}" id="edit-form-{{ $comment->id }}" data-comment-id="{{ $comment->id }}">
                                @csrf
                                @method('PUT')
                                <textarea name="comment" class="w-full p-2 border rounded" rows="4">{{ $comment->comment }}</textarea>
                                <button type="button" class="mt-2 bg-blue-500 text-white p-2 rounded save-button" data-comment-id="{{ $comment->id }}">Save</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Проверка дали бутоните за редактиране съществуват
        const editButtons = document.querySelectorAll('.edit-button');
        if (editButtons.length > 0) {
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.dataset.commentId;
                    editComment(commentId);
                });
            });
        }

        function editComment(commentId) {
            document.getElementById('comment-' + commentId + '-text').style.display = 'none';
            document.getElementById('edit-row-' + commentId).style.display = 'table-row';
        }

        // Проверка дали бутоните за записване съществуват
        const saveButtons = document.querySelectorAll('.save-button');
        if (saveButtons.length > 0) {
            saveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.dataset.commentId;
                    saveComment(commentId);
                });
            });
        }

        function saveComment(commentId) {
            const textarea = document.querySelector(`#edit-form-${commentId} textarea`);
            if (!textarea) {
                console.error('Textarea not found for comment ' + commentId);
                return;
            }

            const newText = textarea.value;

            fetch(`/admin/comments/${commentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ text: newText })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('comment-' + commentId + '-text').innerText = newText;
                        document.getElementById('edit-row-' + commentId).style.display = 'none';
                        document.getElementById('comment-' + commentId + '-text').style.display = 'table-cell';
                    } else {
                        alert('Failed to update comment');
                    }
                })
                .catch(error => {
                    alert('An error occurred while updating the comment');
                });
        }
    });
</script>
