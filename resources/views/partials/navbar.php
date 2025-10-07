<nav class="bg-white/80 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center space-x-8">
<!--                <a href="#" class="flex items-center space-x-2 group">-->
<!--                    <div class="w-8 h-8 items-center justify-center">-->
<!--                        <img src="assets/image/logo.png">-->
<!--                    </div>-->
<!--                </a>-->

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                       class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors relative group">
                        Home
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4">
                <div id="guestLinks" class="hidden md:flex items-center space-x-4">
                    <?php if (!isset($_SESSION['user']) ?? false): ?>
                    <a href="/login" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                        Login
                    </a>
                    <a href="/register"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Cadastrar
                    </a>
                    <?php endif ?>

                    <?php if (isset($_SESSION['user']) ?? false): ?>
                    <form action="/logout" method="post">
                        <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">Log Out</button>
                    </form>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</nav>