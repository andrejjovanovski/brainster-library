<?php
require_once "./partials/header.php";
session_start();
?>

<div class="wrapper w-full h-screen bg-indigo-900 flex justify-center items-center">
    <div class="w-full max-w-lg p-4">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="./validate-login.php" novalidate>
            <h2 class="mb-5 text-3xl text-center">Login</h2>
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="user-credential">
                        Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="user-credential" type="text" name="user-credential" placeholder="Enter your username" required>
                    <p class="text-red-500 text-xs italic credential-error"><?= isset($_SESSION['loginValidationError']['username']) ? $_SESSION['loginValidationError']['username'] : '' ?></p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Enter your password">
                    <p class="text-red-500 text-xs italic password-error"><?= isset($_SESSION['loginValidationError']['password']) ? $_SESSION['loginValidationError']['password'] : '' ?></p>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Login
                </button>
            </div>
        </form>
        <p class="font-bold text-white text-center mb-5 mt-5">New to Brainster Library? <a href="./register.php" class="ml-3 bg-blue-500 hover:bg-blue-700 px-5 py-2 rounded focus:shadow-outline">Join now</a></p>
        <?php require_once "./partials/copyright-form-footer.php"?>
    </div>
</div>


<script src="js/validate-login-form.js"></script>

<?php
require_once "./partials/footer.php";
unset($_POST, $_SESSION['loginValidationError']);
?>
