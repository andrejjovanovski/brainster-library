<nav class="flex items-center justify-between flex-wrap bg-indigo-900 p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
        <a href="./index.php" class="font-semibold text-xl tracking-tight mr-5">Brainster Library</a>
    </div>
    <div class="block lg:hidden">
        <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-white border-white hover:text-indigo-900 hover:bg-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
            </svg>
        </button>
    </div>
    <div id="nav-content" class="w-full block flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block">
        <div class="text-sm lg:flex-grow">
            <?php
            if (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] === 1) {
                echo '<a href="./admin-dashboard.php" class="block ml-3 mt-4 lg:inline-block lg:mt-0 lg:ml-0 text-white hover:text-white mr-4">Dashboard</a>';
                echo '<a href="./comments.php" class="block mt-4 ml-3 lg:inline-block lg:mt-0 lg:ml-0 text-white hover:text-white mr-4">Comments</a>';
            }
            ?>
        </div>
        <div>
            <?php if (!isset($_SESSION['user'])) : ?>
                <a href="./register.php"
                   class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-indigo-900 hover:bg-white mt-4 lg:mt-0">Register</a>
                <a href="./login.php"
                   class="inline-block text-sm ml-2 px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-indigo-900 hover:bg-white mt-4 lg:mt-0">Login</a>
            <?php else : ?>
                <p class="inline-block uppercase text-gray-500 font-bold underline">Logged in as <?= $_SESSION['user']['name'] ?></p>
                <a href="./logout.php"
                   class="inline-block text-sm ml-2 px-4 py-2 leading-none border-red-600 rounded text-white bg-red-600 hover:border-transparent hover:bg-red-700 mt-4 lg:mt-0">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    document.getElementById('nav-toggle').onclick = function() {
        var navContent = document.getElementById('nav-content');
        if (navContent.classList.contains('hidden')) {
            navContent.classList.remove('hidden');
        } else {
            navContent.classList.add('hidden');
        }
    }
</script>