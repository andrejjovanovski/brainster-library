$(document).ready(function () {

    function loadNotes(bookID, clientID) {
        $.ajax({
            url: 'api/get_notes.php',
            method: 'GET',
            dataType: 'json',
            data: { bookID: bookID, clientID: clientID },
            success: function(notes) {
                $('#listAllNotes').empty().html(`<h2 class="text-lg lg:text-xl font-bold text-gray-900 mb-1">My notes</h2>`);
                notes.forEach(function(note) {
                    $('#listAllNotes').append(`
                    <article class="p-3 text-base bg-white rounded-lg">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold">${note.client_note_name} ${note.client_note_lastname}</p>
                                <button id="editNoteBtn" class="text-sm text-blue-600 dark:text-blue-500 hover:underline ml-2" data-noteid="${note.id}">Edit</button>
                                <button id="deleteNoteBtn" class="text-sm text-blue-600 dark:text-blue-500 hover:underline ml-2" data-noteid="${note.id}">Delete</button>
                            </div>
                        </footer>
                        <p class="text-gray-600">${note.note}</p>
                    </article>
                `);
                });
            }
        });
    }

    $('#noteForm').on('submit', function(event) {
        event.preventDefault();
        const note = $('#noteInput').val();
        const noteID = $('#noteID').val();
        const bookID = $('#bookID').val();
        const clientID = $('#clientID').val();
        $('.notes-error').text("");
        if (note.length === 0) {
            $('.notes-error').text("Field can't be empty");
        } else {
            const url = noteID ? 'api/update_note.php' : 'api/add_note.php';
            const method = noteID ? 'PUT' : 'POST';
            const data = noteID ? JSON.stringify({ id: noteID, note: note}) : JSON.stringify({client_id: clientID, book_id: bookID, note: note });
            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#noteInput').val("");
                        $('#noteID').val("");
                        $('#noteSubmitBtn').text('Add note');

                        loadNotes(parseInt(bookID), clientId);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: `Note successfully ${noteID ? 'updated' : 'added'}!`
                        });
                    }
                }
            });
        }
    });

    $(document).on('click', '#deleteNoteBtn', function () {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                const noteID = $(this).data('noteid');
                $.ajax({
                    url: 'api/delete_note.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: noteID }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const bookID = $('#bookID').val();
                            loadNotes(bookID, clientId);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Error deleting category.');
                    }
                });
                Swal.fire({
                    title: "Deleted!",
                    text: `Note has been deleted.`,
                    icon: "success"
                });
            }
        });
    });

    $(document).on('click', '#editNoteBtn', function () {
        const noteID = $(this).data('noteid');
        $('html, body').animate({ scrollTop: 500 }, 'slow');
        $.ajax({
            url: 'api/get_note.php',
            method: 'GET',
            data: { id: noteID },
            dataType: 'json',
            success: function(note) {
                $('#noteInput').val(note.note);
                $('#noteID').val(note.id);
                $('#noteSubmitBtn').html('<i class="far fa-save mr-2"></i>Save changes');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Error fetching note details.');
            }
        });
    });

    loadNotes(parseInt($('#bookID').val()), clientId)
});