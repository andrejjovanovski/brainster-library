<?php
require_once "./partials/header.php";
?>

    <div class="wrapper w-full h-screen bg-indigo-900 flex justify-center items-center">
        <div class="w-full max-w-3xl p-4">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="./register-client.php" novalidate>
                <h2 class="mb-5 text-3xl text-center">Register</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Name" required>
                            <p class="text-red-500 text-xs italic name-error"><?= isset($_SESSION['registerErrorMessages']['name']) ? $_SESSION['registerErrorMessages']['name'] : '' ?></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastName">
                                Last name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="lastName" name="lastname" type="text" placeholder="Last name" required>
                            <p class="text-red-500 text-xs italic lastname-error"><?= isset($_SESSION['registerErrorMessages']['lastname']) ? $_SESSION['registerErrorMessages']['lastname'] : '' ?></p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                                Username
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username" placeholder="Username" minlength="4" maxlength="12" required>
                            <p class="text-red-500 text-xs italic username-error"><?= isset($_SESSION['registerErrorMessages']['username']) ? $_SESSION['registerErrorMessages']['username'] : '' ?></p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Email" minlength="8" required>
                            <p class="text-red-500 text-xs italic email-error"><?= isset($_SESSION['registerErrorMessages']['email']) ? $_SESSION['registerErrorMessages']['email'] : '' ?></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Password
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="password" name="password" type="password" placeholder="Enter your password">
                            <p class="text-red-500 text-xs italic password-error"><?= isset($_SESSION['registerErrorMessages']['password']) ? $_SESSION['registerErrorMessages']['password'] : '' ?></p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirmPassword">
                                Confirm Password
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm Password">
                            <p class="text-red-500 text-xs italic confirm-password-error"><?= isset($_SESSION['registerErrorMessages']['confirmPassword']) ? $_SESSION['registerErrorMessages']['confirmPassword'] : '' ?></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Register
                    </button>
                </div>
            </form>
            <p class="font-bold text-white text-center mb-5 mt-5">Already a user? <a href="./login.php" class="ml-3 bg-blue-500 hover:bg-blue-700 px-5 py-2 rounded focus:shadow-outline">Login</a></p>
            <?php require_once "./partials/copyright-form-footer.php"?>
        </div>
    </div>

<?php
require_once "./partials/footer.php";
?>


<script src="./js/validate-register-form.js"></script>
