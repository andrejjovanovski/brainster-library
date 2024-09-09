$(document).ready(function() {
    function loadAuthors() {
        $.ajax({
            url: 'api/get_authors.php',
            method: 'GET',
            dataType: 'json',
            success: function(authors) {
                $('#authorID').empty().append('<option value="">Select author</option>');
                $('#authorsTableBody').empty();
                authors.forEach(function(author) {
                    if (parseInt(author.is_archived) !== 1) {
                        $('#authorID').append(`<option value="${author.id}">${author.name} ${author.last_name}</option>`);
                    }
                    $('#authorsTableBody').append(`                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        ${author.id}
                                    </th>
                                    <td class="px-6 py-4">
                                        ${author.name}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${author.last_name}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${author.bio}
                                    </td>
                                     <td class="px-6 py-4">
                                        ${author.is_archived == 1 ? 'Yes' : 'No'}
                                    </td>    
                                    <td class="px-6 py-4">
                                        ${author.created_at}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2" id="editAuthorButton" data-authorID = "${author.id}">Edit</button>
                                        ${author.is_archived == 1 ? '' : `<button class="font-medium text-blue-600 dark:text-blue-500 hover:underline" id="deleteAuthorButton" data-authorID = "${author.id}">Delete</button>`}
                                        
                                    </td>
                                </tr>`);
                });
            }
        });
    }

    $('#authorForm').on('submit', function(event) {
        event.preventDefault();
        const name = $('#authorName').val();
        const lastname = $('#authorLastname').val();
        const shortBio = $('#authorBio').val();
        const authorId = $('#authorId').val();
        const isArchived = $('#isArchivedAuthor').is(':checked') ? 1 : 0;

        let validationErrors = 0

        if (name.length === 0) {
            $('.author-name-error').text("Field can't be empty")
            validationErrors++
        } else {
            $('.author-name-error').text("")
            validationErrors = 0
        }
        if (lastname.length === 0) {
            $('.author-lastname-error').text("Field can't be empty")
            validationErrors++
        } else {
            $('.author-lastname-error').text("")
            validationErrors = 0
        }
        if (shortBio.length === 0) {
            $('.author-bio-error').text("Field can't be empty")
            validationErrors++
        } else {
            $('.author-bio-error').text("")
            validationErrors = 0
        }

        if (validationErrors === 0) {
            const url = authorId ? 'api/update_author.php' : 'api/add_author.php';
            const method = authorId ? 'PUT' : 'POST';
            const data = authorId ? JSON.stringify({ id: authorId, name: name, lastname: lastname, short_bio: shortBio, is_archived: isArchived }) : JSON.stringify({ name: name, lastname: lastname, short_bio: shortBio });
            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#authorName').val("")
                        $('#authorLastname').val("")
                        $('#authorBio').val("")
                        $('#authorId').val("")
                        $('#isArchivedAuthor').prop('checked', false)
                        $('#isArchivedContainerAuthor').hide();
                        $('#authorSubmitBtn').html('<i class="fas fa-plus mr-2"></i>Add new author');
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
                            title: `Author successfully ${authorId ? 'updated' : 'added'}!`
                        });
                        loadAuthors();
                    }
                }
            });
        }

    });

    $(document).on('click', '#deleteAuthorButton', function () {
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
                const categoryID = $(this).data('authorid');
                console.log('Category ID:', categoryID);
                $.ajax({
                    url: 'api/delete_author.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: categoryID }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            loadAuthors()
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Error deleting author.');
                    }
                });
                Swal.fire({
                    title: "Deleted!",
                    text: `Author with ID = ${categoryID} has been deleted.`,
                    icon: "success"
                });
            }
        });
    })

    $(document).on('click', '#editAuthorButton', function () {
        const authorID = $(this).data('authorid');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $.ajax({
            url: 'api/get_author.php',
            method: 'GET',
            data: { id: authorID },
            dataType: 'json',
            success: function(author) {
                $('#authorId').val(author.id);
                $('#authorName').val(author.name);
                $('#authorLastname').val(author.last_name);
                $('#authorBio').val(author.bio);
                $('#isArchivedAuthor').prop('checked', author.is_archived == 1);
                $('#isArchivedContainerAuthor').show();
                $('#authorSubmitButton').html('<i class="far fa-save mr-2"></i>Save changes');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Error fetching author details.');
            }
        });
    });

    $('#isArchivedContainerAuthor').hide();

    // Load authors on page load
    loadAuthors();
});