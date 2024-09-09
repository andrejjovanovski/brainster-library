$(document).ready(function() {
    function loadCategories() {
        $.ajax({
            url: 'api/get_categories.php',
            method: 'GET',
            dataType: 'json',
            success: function(categories) {
                $('#category').empty().append('<option value="">Select category</option>');
                $('#categoryTableBody').empty();
                categories.forEach(function(category) {
                    if (parseInt(category.is_archived) !== 1) {
                        $('#category').append(`<option value="${category.id}">${category.title}</option>`);
                    }
                    $('#categoryTableBody').append(`                                
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                ${category.id}
                            </th>
                            <td class="px-6 py-4">
                                ${category.title}
                            </td>
                            <td class="px-6 py-4">
                                ${category.is_archived == 1 ? 'Yes' : 'No'}
                            </td>
                            <td class="px-6 py-4">
                                ${category.created_at}
                            </td>
                            <td class="px-6 py-4">
                                <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2" id="editCategoryButton" data-categoryid="${category.id}">Edit</button>
                                ${category.is_archived == 1 ? '' : `<button class="font-medium text-blue-600 dark:text-blue-500 hover:underline" data-categoryid="${category.id}" id="deleteCategoryBtn">Delete</button>`} 
                            </td>
                        </tr>`);
                });
            }
        });
    }

    $('#categoryForm').on('submit', function(event) {
        event.preventDefault();
        const categoryName = $('#categoryName').val();
        const categoryId = $('#categoryId').val();
        const isArchived = $('#isArchived').is(':checked') ? 1 : 0;
        $('.category-error').text("");
        if (categoryName.length === 0) {
            $('.category-error').text("Field can't be empty");
        } else {
            const url = categoryId ? 'api/update_category.php' : 'api/add_category.php';
            const method = categoryId ? 'PUT' : 'POST';
            const data = categoryId ? JSON.stringify({ id: categoryId, name: categoryName, is_archived: isArchived }) : JSON.stringify({ name: categoryName });
            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#categoryName').val("");
                        $('#categoryId').val("");
                        $('#isArchived').prop('checked', false);
                        $('#isArchivedContainer').hide();
                        $('#categorySubmitBtn').html('<i class="fas fa-plus mr-2"></i>Add new category');

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
                            title: `Category successfully ${categoryId ? 'updated' : 'added'}!`
                        });
                        loadCategories();

                    }
                }
            });
        }
    });

    $(document).on('click', '#deleteCategoryBtn', function () {
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
                const categoryID = $(this).data('categoryid');
                $.ajax({
                    url: 'api/delete_category.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: categoryID }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            loadCategories();
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
                    text: `Category with ID = ${categoryID} has been deleted.`,
                    icon: "success"
                });
            }
        });
    });

    $(document).on('click', '#editCategoryButton', function () {
        const categoryID = $(this).data('categoryid');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $.ajax({
            url: 'api/get_category.php',
            method: 'GET',
            data: { id: categoryID },
            dataType: 'json',
            success: function(category) {
                $('#categoryId').val(category.id);
                $('#categoryName').val(category.title);
                $('#isArchived').prop('checked', category.is_archived == 1);
                $('#isArchivedContainer').show();
                $('#categorySubmitBtn').html('<i class="far fa-save mr-2"></i>Save changes');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Error fetching category details.');
            }
        });
    });

    // Hide isArchived field initially
    $('#isArchivedContainer').hide();

    // Load categories on page load
    loadCategories();
});