$(document).ready(function() {
    $('#categoryFilters input[type="checkbox"]').on('change', function() {
        var selectedCategories = $('#categoryFilters input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedCategories.length === 0) {
            $('.book-item').each(function() {
                $(this).show();
            });
        } else {
            $('.book-item').each(function() {
                var itemCategory = $(this).data('category');
                if (selectedCategories.includes(itemCategory)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });

    // Initially display all items
    $('.book-item').each(function() {
        $(this).show();
    });
});