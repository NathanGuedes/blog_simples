<?php use Random\RandomException;

$this->layout('layouts/auth', ['title' => 'Log In']) ?>

<div class="flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Bem-vindo de volta!</h2>
                <p class="text-gray-600 text-sm">Entre com a sua conta para continuar</p>
                <?= flash('error', 'text-xs text-red-500') ?>
                <?= flash('success', 'text-xs text-green-500') ?>
            </div>

            <form id="loginForm" class="space-y-6" method="post" action="/login">
                <!-- Csrf-->
                <?php try {
                    echo getToken();
                } catch (RandomException $e) {

                } ?>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="seu@email.com",
                               value="<?= flashOld('emailField') ?>">
                    </div>
                    <?= flash('email', 'text-xs text-red-500') ?>
                </div>

                <!-- Senha -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50 backdrop-blur-sm"
                               placeholder="••••••••">
                    </div>
                    <?= flash('password', 'text-xs text-red-500') ?>
                </div>

                <!-- Opções -->
                <div class="flex items-center justify-between">
                    <a href="/forgot/password/email"
                       class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        Esqueci minha senha
                    </a>
                </div>

                <!-- Botão Login -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02]">
                    Entrar
                </button>
            </form>

            <!-- Link para registro -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Não tem uma conta?
                    <a href="/register" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        Cadastre-se
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
