<nav class="bg-white/80 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center space-x-8">
                <!--                <a href="#" class="flex items-center space-x-2 group">-->
                <!--                    <div class="w-8 h-8 items-center justify-center">-->
                <!--                        <img src="assets/image/logo.png">-->
                <!--                    </div>-->
                <!--                </a>-->

                <!-- Navigation Links - Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                       class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors relative group">
                        Home
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
            </div>

            <!-- Auth Section - Desktop -->
            <div class="hidden md:flex items-center space-x-4">
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
                    <!-- User Menu Dropdown -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Menu</span>
                            <svg class="w-4 h-4 transition-transform" id="userMenuArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="/user/profile/<?=$_SESSION['user']['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Perfil</span>
                                </div>
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form action="/logout" method="post">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Log Out</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg id="menuIcon" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="closeIcon" class="w-6 h-6 text-gray-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden pb-4 pt-2 border-t border-gray-200/50 mt-2">
            <div class="flex flex-col space-y-3">
                <a href="/" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors py-2">
                    Home
                </a>

                <?php if (!isset($_SESSION['user']) ?? false): ?>
                    <a href="/login" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors py-2">
                        Login
                    </a>
                    <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                        Cadastrar
                    </a>
                <?php endif ?>

                <?php if (isset($_SESSION['user']) ?? false): ?>
                    <a href="/profile" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors py-2">
                        Perfil
                    </a>
                    <form action="/logout" method="post">
                        <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors py-2 w-full text-left">
                            Log Out
                        </button>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });

    // Desktop User Menu Dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    const userMenuArrow = document.getElementById('userMenuArrow');

    if (userMenuBtn) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('hidden');
            userMenuArrow.classList.toggle('rotate-180');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.add('hidden');
                userMenuArrow.classList.remove('rotate-180');
            }
        });
    }
</script>