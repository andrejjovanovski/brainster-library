$(document).ready(function () {
    function loadBooks() {
        $.ajax({
            url: 'api/get_books.php',
            method: 'GET',
            dataType: 'json',
            success: function (books) {
                $('#booksTableBody').empty();
                books.forEach(function (book) {
                    $('#booksTableBody').append(`                               
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        ${book.id}
                                    </th>
                                    <td class="px-6 py-4">
                                        ${book.title}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${book.total_pages}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${book.book_author_name} ${book.book_author_lastname}
                                    </td>
                                     <td class="px-6 py-4">
                                        ${book.cover_img_url}
                                    </td>    
                                    <td class="px-6 py-4">
                                        ${book.book_category_title}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${book.published_in}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${book.created_at}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2" id="editBookButton" data-bookID="${book.id}">Edit</button>
                                        <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline" id="deleteBookButton" data-bookID="${book.id}">Delete</button>
                                    </td>
                                </tr>`);
                });
            }
        });
    }

    $('#bookForm').on('submit', function (event) {
        event.preventDefault();
        console.log('test')
        const title = $('#title').val();
        const authorID = $('#authorID').val();
        const publishedIn = $('#publishedIn').val();
        const totalPages = $('#totalPages').val();
        const coverImageURL = $('#coverImageURL').val();
        const category = $('#category').val();
        const bookId = $("#bookId").val();


        let validationError = 0;

        if (title.length === 0) {
            $(".title-error").text("Field can't be empty")
            validationError++
        } else {
            $(".title-error").text("")
        }
        if (authorID === "") {
            $(".book-author-error").text("Field can't be empty")
            validationError++
        } else {
            $(".book-author-error").text("")
            validationError = 0
        }
        if (publishedIn.length === 0) {
            $(".published-in-error").text("Field can't be empty")
            validationError++
        } else {
            $(".published-in-error").text("")
            validationError = 0
        }
        if (totalPages.length === 0) {
            $(".pages-error").text("Field can't be empty")
            validationError++
        } else {
            $(".pages-error").text("")
            validationError = 0
        }
        if (coverImageURL.length === 0) {
            $(".image-url-error").text("Field can't be empty")
            validationError++
        } else {
            $(".image-url-error").text("")
            validationError = 0
        }
        if (category === "") {
            $(".book-category-error").text("Field can't be empty")
            validationError++
        } else {
            $(".book-category-error").text("")
            validationError = 0
        }

        console.log(validationError)


        if (validationError === 0) {

            const url = bookId ? 'api/update_book.php' : 'api/add_book.php';
            const method = bookId ? 'PUT' : 'POST';
            const data = bookId ? JSON.stringify({id: bookId, title: title, authorID: authorID, publishedIn: publishedIn, totalPages: totalPages, coverImageURL: coverImageURL, category: category}) : JSON.stringify({title: title, authorID: authorID, publishedIn: publishedIn, totalPages: totalPages, coverImageURL: coverImageURL, category: category})
            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#title').val("");
                        $('#authorID').val("");
                        $('#publishedIn').val("");
                        $('#totalPages').val("");
                        $('#coverImageURL').val("");
                        $('#category').val("");
                        $('bookId').val("");
                        $('#bookSubmitBtn').html('<i class="fas fa-plus mr-2"></i>Add new category');
                        loadBooks();

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
                            title: `Book successfully ${bookId ? 'updated' : 'added'}!`
                        });
                    } else {
                        alert("error")
                    }
                }
            });
        }
    });

    $(document).on('click', '#deleteBookButton', function () {
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
                const bookID = $(this).data('bookid');
                $.ajax({
                    url: 'api/delete_book.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: bookID }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            loadBooks()
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Error deleting book.');
                    }
                });
                Swal.fire({
                    title: "Deleted!",
                    text: `Book with ID = ${bookID} has been deleted.`,
                    icon: "success"
                });
            }
        });
    })

    $(document).on('click', '#editBookButton', function () {
        const bookID = $(this).data('bookid');
        $('html, body').animate({ scrollTop: 600 }, 'slow');
        $.ajax({
            url: 'api/get_book.php',
            method: 'GET',
            data: { id: bookID },
            dataType: 'json',
            success: function(book) {
                $('#bookId').val(book.id);
                $('#title').val(book.title);
                $('#authorID').val(book.author_id);
                $('#publishedIn').val(book.published_in);
                $('#totalPages').val(book.total_pages);
                $('#coverImageURL').val(book.cover_img_url);
                $('#category').val(book.category_id);

                $('#bookSubmitBtn').html('<i class="far fa-save mr-2"></i>Save changes');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Error fetching book details.');
            }
        });
    });

    // Load authors on page load
    loadBooks();
});