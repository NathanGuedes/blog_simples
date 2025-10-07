<?php $this->layout('layouts/auth', ['title' => 'Verificar E-mail']); ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Card Container -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-200/50 p-8 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 mb-6">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Verifique seu E-mail
            </h2>

            <!-- Message -->
            <div class="mb-8">
                <p class="text-lg text-gray-700 mb-4">
                    Enviamos um link para o seu e-mail.
                </p>
                <p class="text-gray-600">
                    Por favor, verifique sua caixa de entrada e clique no link.
                </p>
            </div>

            <!-- Email Display -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-2xl p-4 mb-8">
                <p class="text-sm text-gray-600 mb-1">E-mail enviado para:</p>
                <p class="text-blue-600 font-semibold text-lg"><?= $email?></p>
            </div>

            <!-- Warning Box -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4 mb-8">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <p class="text-sm text-yellow-800">
                        <span class="font-medium">Importante:</span> O link expira em 15 minutos.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="/login" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-2xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 hover:scale-105 hover:shadow-lg inline-block">
                    Ir para Login
                </a>

                <a href="/" class="w-full border-2 border-gray-300 text-gray-700 py-3 px-6 rounded-2xl font-semibold text-lg hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 inline-block">
                    Voltar ao Início
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-4">
                    Não recebeu o e-mail?
                </p>

                <div class="space-y-2 text-sm text-gray-500">
                    <p>• Verifique sua pasta de spam/lixo eletrônico</p>
                    <p>• Aguarde alguns minutos, pode haver atraso na entrega</p>
                    <p>• Certifique-se de que o endereço de e-mail está correto</p>
                </div>

<!--                <button onclick="resendEmail()" class="mt-4 text-blue-600 hover:text-blue-800 font-medium text-sm underline transition-colors duration-200">-->
<!--                    Reenviar e-mail de verificação-->
<!--                </button>-->
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="bg-white/60 backdrop-blur-sm rounded-2xl border border-gray-200/30 p-6 text-center">
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Seguro</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Rápido</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Confiável</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Erro -->
<div id="errorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="errorModalContent">
        <!-- Header do Modal -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mr-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Aviso</h3>
            </div>
            <button onclick="closeErrorModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Corpo do Modal -->
        <div class="p-6">
            <div class="mb-6">
                <p class="text-gray-700 text-lg mb-2" id="errorTitle">
                    Link Expirado
                </p>
                <p class="text-gray-600" id="errorMessage">
                    <?php echo flash('token_error') ?>
                </p>
            </div>

            <!-- Botões de Ação -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="closeErrorModal()" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-2xl font-semibold hover:bg-gray-200 transition-all duration-300">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para mostrar o modal de erro
    function showErrorModal(title = 'Ops! Algo deu errado', message = 'Não foi possível processar sua solicitação. Por favor, tente novamente.', details = null) {
        const modal = document.getElementById('errorModal');
        const modalContent = document.getElementById('errorModalContent');
        const errorTitle = document.getElementById('errorTitle');
        const errorMessage = document.getElementById('errorMessage');
        const errorDetails = document.getElementById('errorDetails');
        const errorDetailsText = document.getElementById('errorDetailsText');

        // Define o conteúdo do modal
        errorTitle.textContent = title;
        errorMessage.textContent = message;

        // Mostra detalhes técnicos se fornecidos
        if (details) {
            errorDetailsText.textContent = details;
            errorDetails.classList.remove('hidden');
        } else {
            errorDetails.classList.add('hidden');
        }

        // Mostra o modal com animação
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Função para fechar o modal de erro
    function closeErrorModal() {
        const modal = document.getElementById('errorModal');
        const modalContent = document.getElementById('errorModalContent');

        // Animação de fechamento
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Função para reenviar e-mail com tratamento de erro
    function resendEmail() {
        // Simular chamada AJAX (substitua pela sua implementação)
        fetch('/resend-verification-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                email: '<?= $email ?? "" ?>'
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Sucesso - mostrar mensagem de confirmação
                    alert('E-mail reenviado com sucesso!');
                } else {
                    // Erro do servidor
                    showErrorModal(
                        'Erro ao reenviar e-mail',
                        data.message || 'Não foi possível reenviar o e-mail de verificação.',
                        data.error || null
                    );
                }
            })
            .catch(error => {
                // Erro de rede ou outros erros
                showErrorModal(
                    'Erro de conexão',
                    'Não foi possível conectar ao servidor. Verifique sua conexão com a internet.',
                    error.message
                );
            });
    }

    // Função para tentar novamente (pode ser personalizada)
    function retryAction() {
        closeErrorModal();
        // Aqui você pode implementar a lógica para tentar novamente a última ação
        // Por exemplo, se o erro foi no reenvio de e-mail:
        // resendEmail();
    }

    // Fechar modal ao clicar no backdrop
    document.getElementById('errorModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeErrorModal();
        }
    });

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('errorModal');
            if (!modal.classList.contains('hidden')) {
                closeErrorModal();
            }
        }
    });

    // Exemplo de como usar o modal (remova em produção)
    <?php if (isset($error)): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showErrorModal(
            '<?= $error['title'] ?? 'Erro' ?>',
            '<?= $error['message'] ?? 'Ocorreu um erro inesperado.' ?>',
            '<?= $error['details'] ?? '' ?>'
        );
    });
    <?php endif; ?>
</script>