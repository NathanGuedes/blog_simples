<?php $this->layout('layouts/master', ['title' => 'Home']) ?>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl p-12 mb-12 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20 rounded-3xl"></div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                Welcome <?= htmlspecialchars(strstr($_SESSION['user']['name'] ?? "Guest ",' ', true)) ?>
            </h1>
        </div>
    </div>
</div>