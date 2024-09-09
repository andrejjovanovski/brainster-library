<?php
require_once "./partials/header.php";
session_start();
require_once "./partials/navbar.php";
require_once "./Books/Book.php";
require_once "./Categories/Category.php";

use Books\Book as Book;
use Categories\Category as Category;

$book = new Book();
$allBooks = $book->listAllBooks();

$category = new Category();
$allCategories = $category->getAllAvailableCategories();
?>

<?php if (isset($_SESSION['user']['login-successful'])) : ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "Signed in successfully"
        });
    </script>
<?php
endif;
unset($_SESSION['user']['login-successful']);
?>

<div class="flex-grow">

    <div class="mt-5 mb-5">
        <p class="text-center mb-2">Filter categories:</p>
        <div class="flex flex-wrap content-center justify-center" id="categoryFilters">
            <?php foreach ($allCategories as $category) : ?>
                <div class="flex items-center mb-2 me-4">
                    <input id="<?= $category['id'] ?>" type="checkbox" value="<?= $category['title'] ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="<?= $category['id'] ?>" class="ms-1 text-sm font-medium text-gray-900"><?= $category['title'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <section class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">

        <?php foreach ($allBooks as $book) : ?>
            <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl book-item" data-category="<?= $book['book_category_title'] ?>">
                <a href='view_book.php?id=<?= $book['id']?>'>
                    <img src="<?= $book['cover_img_url'] ?>"
                         alt="Product" class="h-80 w-72 object-cover rounded-t-xl"/>
                    <div class="px-4 py-3 w-72">
                        <span class="text-gray-400 mr-3 uppercase text-xs"><?= $book['book_author_name'], ' ', $book['book_author_lastname'] ?></span>
                        <p class="text-lg font-bold text-black truncate block capitalize"><?= $book['title'] ?></p>
                        <p class="text-sm text-gray-600 cursor-auto my-3"><i class="far fa-bookmark mr-2"></i><?= $book['book_category_title'] ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </section>
</div>

    <script src="./js/category-filter.js"></script>

<?php
require_once "./partials/footer.php";
?>