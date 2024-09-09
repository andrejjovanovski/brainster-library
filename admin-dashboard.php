<?php
require_once "./partials/header.php";
session_start();
if ($_SESSION['user']['isAdmin'] === 0) {
    header('Location: index.php');
    die();
}

require_once "./partials/navbar.php";
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

<div class="bg-gray-100 font-family-karla flex-grow">
    <div class="w-full flex flex-col">

        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Dashboard</h1>
                <div class="flex flex-wrap mt-6">

                    <!--                CATEGORIES-->
                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-bookmark mr-3"></i> Manage Categories
                        </p>
                        <div class="p-6 bg-white lg:h-96 flex justify-center items-center">
                            <form class="px-8 pt-6 mb-4 w-full" id="categoryForm" method="POST">
                                <div class="mb-4">
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="categoryId" name="categoryId" type="text" hidden="">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="categoryName">
                                        Add new category
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="categoryName" name="categoryName" type="text"
                                           placeholder="Category name">
                                    <p class="text-red-500 text-xs italic category-error"></p>
                                </div>
                                <div class="mb-4" id="isArchivedContainer">
                                    <label class="text-gray-700 text-sm font-bold mr-2" for="isArchived">
                                        Is Archived?
                                    </label>
                                    <input type="checkbox" name="isArchived" id="isArchived">
                                </div>
                                <div class="flex items-center justify-center">
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                            id="categorySubmitBtn">
                                        <i class="fas fa-plus mr-2"></i>Add new category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--AUTHORS-->
                    <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-user-edit mr-3"></i> Manage authors
                        </p>
                        <div class="p-6 bg-white lg:h-96">
                            <form class="px-8 pt-6 mb-4" id="authorForm">
                                <div class="mb-4">
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="authorId" name="authorId" type="text" hidden="">
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="authorName">
                                            Author name
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="authorName" name="authorName" type="text"
                                               placeholder="Author name">
                                        <p class="text-red-500 text-xs italic author-name-error"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="authorLastname">
                                            Author lastname
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="authorLastname" name="authorLastname" type="text"
                                               placeholder="Author lastname">
                                        <p class="text-red-500 text-xs italic author-lastname-error"></p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="authorBio">
                                        Author's biography
                                    </label>
                                    <textarea
                                            class="shadow appearance-none border rounded h-32 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"
                                            id="authorBio" name="authorBio"
                                            placeholder="Shot biography about the author's life... "></textarea>
                                    <p class="text-red-500 text-xs italic author-bio-error"></p>
                                </div>
                                <div class="mb-4" id="isArchivedContainerAuthor">
                                    <label class="text-gray-700 text-sm font-bold mr-2" for="isArchivedAuthor">
                                        Is Archived?
                                    </label>
                                    <input type="checkbox" name="isArchivedAuthor" id="isArchivedAuthor">
                                </div>
                                <div class="flex items-center justify-center">
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                            id="authorSubmitButton">
                                        <i class="fas fa-plus mr-2"></i>Add new author
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--BOOKS-->
                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2 mt-10">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-book mr-3"></i> Manage Books
                        </p>
                        <div class="p-6 bg-white">
                            <form class="px-8 pt-6 mb-4" id="bookForm">
                                <div class="mb-4">
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           id="bookId" name="bookId" type="text" hidden="">
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                            Title
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="title" name="title" type="text"
                                               placeholder="Book title">
                                        <p class="text-red-500 text-xs italic title-error"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="authorID">
                                            Author
                                        </label>
                                        <div class="relative">
                                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="authorID" name="authorID">
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20">
                                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-red-500 text-xs italic book-author-error"></p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="publishedIn">
                                            Published in
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="publishedIn" name="publishedIn" type="number"
                                               placeholder="Published in (year)">
                                        <p class="text-red-500 text-xs italic published-in-error"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPages">
                                            Total pages
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="totalPages" name="totalPages" type="number"
                                               placeholder="Total pages">
                                        <p class="text-red-500 text-xs italic pages-error"></p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 mb-4">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="coverImageURL">
                                            Cover image url
                                        </label>
                                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               id="coverImageURL" name="coverImageURL" type="text"
                                               placeholder="Image url">
                                        <p class="text-red-500 text-xs italic image-url-error"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                            Category
                                        </label>
                                        <div class="relative">
                                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="category" name="category"></select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20">
                                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-red-500 text-xs italic book-category-error"></p>
                                    </div>
                                </div>
                                <!--BUTTON-->
                                <div class="flex items-center justify-center">
                                    <button id="bookSubmitBtn"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <i class="fas fa-plus mr-2"></i>Add new book
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--                TABLES-->
                <div class="w-full mt-12">

                    <!--                BOOKS TABLE-->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <h2 class="mb-3 font-bold text-xl">Books</h2>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    total pages
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Author
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    cover image url
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    published in
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    created at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody id="booksTableBody"></tbody>
                        </table>
                    </div>

                    <!--                CATEGORIES TABLE-->
                    <div class="flex flex-wrap mt-6">
                        <div class="w-full lg:w-1/2 pr-0 lg:pr-2 mt-10">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <h2 class="mb-3 font-bold text-xl">Categories</h2>
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Is deleted
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created on
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="categoryTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--                    AUTHOTS TABLE-->
                        <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-10">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <h2 class="mb-3 font-bold text-xl">Authors</h2>
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Lastname
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Bio
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Is Deleted
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created at
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="authorsTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!--Category Validations-->
    <script src="./js/category.js"></script>

    <script src="./js/book.js"></script>

    <script src="./js/author.js"></script>
</div>


<?php
require_once "./partials/footer.php";
?>
