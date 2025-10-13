<?php $this->layout('layouts/auth', ['title' => 'NotFound']) ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Main 404 Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-200/50 p-8 text-center relative overflow-hidden">
            <!-- Background Animation Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full animate-pulse"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-pink-400/20 to-orange-400/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/3 left-1/4 w-16 h-16 bg-gradient-to-br from-green-400/20 to-teal-400/20 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10">
                <!-- 404 Number -->
                <div class="mb-6">
                    <h1 class="text-8xl md:text-9xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                        404
                    </h1>
                    <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
                </div>

                <!-- Error Message -->
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        Oops! Página não encontrada
                    </h2>
                    <p class="text-lg text-gray-600 mb-4">
                        A página que você está procurando não existe ou foi movida para outro local.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4 mb-8">
                    <a href="/" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-2xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 hover:scale-105 hover:shadow-lg inline-block">
                        🏠 Voltar ao Início
                    </a>

                    <div class="flex space-x-3">
                        <button onclick="history.back()" class="flex-1 border-2 border-gray-300 text-gray-700 py-3 px-4 rounded-2xl font-semibold hover:border-gray-400 hover:bg-gray-50 transition-all duration-300">
                            ← Voltar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>