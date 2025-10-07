<?php use Random\RandomException;
$this->layout('layouts/auth', ['title' => 'Register']) ?>

<div class="flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Crie sua conta</h2>
                <p class="text-gray-600 text-sm">Preencha os dados para começar</p>
                <?= flash('error', 'text-xs text-red-500') ?>

            </div>

            <form id="registerForm" class="space-y-6" method="POST" action="/register">
                <!-- Csrf-->
                 <?php try {
                    echo getToken();
                } catch (RandomException $e) {

                } ?>

                <!-- name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome completo</label>
                    <div class="relative">
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="Seu nome completo"
                               value="<?= flashOld('nameField') ?>">
                    </div>
                    <?= flash('name', 'text-xs text-red-500') ?>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <div class="relative">
                        <input type="text" id="email" name="email"
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="seu@email.com"
                               value="<?= flashOld('emailField') ?>">
                    </div>
                    <?= flash('email', 'text-xs text-red-500') ?>
                </div>

                <!-- password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="••••••••">
                    </div>
                    <?= flash('password', 'text-xs text-red-500') ?>
                </div>

                <!-- confirm password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirme a senha</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="password_confirm" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="••••••••">
                    </div>
                    <?= flash('password_confirm', 'text-xs text-red-500') ?>
                </div>
                <!-- Register button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02]">
                    Criar conta
                </button>
            </form>

            <!-- Link para login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Já tem uma conta?
                    <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        Faça login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>