<?php

use Random\RandomException;

$this->layout('layouts/master', ['title' => 'Editar Postagem']);

?>

<style>
    .post-image {
        max-width: 100%;
        max-height: 500px;
        width: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 lg:gap-8">
        <main class="lg:col-span-3 lg:col-start-2 space-y-8">

            <!-- Formulário de Edição -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Editar Publicação</h2>
                </div>

                <form action="/posts/update" method="post" class="space-y-4" enctype="multipart/form-data">
                    <?php
                    try {
                        echo getToken();
                    } catch (RandomException $e) {
                        // token
                    }
                    ?>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">
                    <input type="hidden" name="remove_image" id="remove_image" value="0">

                    <?= flash('error', 'text-xs text-red-500') ?>

                    <!-- Campo de texto -->
                    <div>
                        <label for="content" class="sr-only">Conteúdo</label>
                        <textarea name="content" id="content" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="No que você está pensando?"><?= htmlspecialchars($post['content']) ?></textarea>
                    </div>
                    <?= flash('content', 'text-xs text-red-500') ?>

                    <!-- Imagem atual -->
                    <?php if (!empty($post['image'])): ?>
                        <div id="currentImageContainer" class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                            <div class="relative inline-block">
                                <img src="data:image/jpeg;base64,<?= htmlspecialchars($post['image']) ?>"
                                     alt="Imagem da postagem"
                                     class="max-h-48 rounded-lg border-2 border-gray-300 mx-auto">
                                <button type="button" onclick="removeCurrentImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors shadow-lg"
                                        title="Remover imagem atual">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Preview da nova imagem -->
                    <div id="imagePreviewContainer" class="hidden">
                        <p class="text-sm text-gray-600 mb-2">Nova imagem:</p>
                        <div class="relative inline-block">
                            <img id="imagePreview" src="" alt="Preview"
                                 class="max-h-48 rounded-lg border-2 border-gray-300">
                            <button type="button" onclick="removeNewImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors shadow-lg"
                                    title="Remover nova imagem">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <p id="imageName" class="text-sm text-gray-600 mt-2"></p>
                    </div>

                    <div class="flex flex-wrap justify-between items-center pt-2 gap-4">
                        <!-- Input imagem -->
                        <div>
                            <label for="image"
                                   class="cursor-pointer text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span id="imageButtonText"><?= !empty($post['image']) ? 'Alterar imagem' : 'Adicionar imagem' ?></span>
                            </label>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*"
                                   onchange="previewImage(event)">
                        </div>

                        <!-- Radios -->
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="radio" name="privacy" id="privacy_public" value="0"
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                        <?= $post['privacy'] == 0 ? 'checked' : '' ?>>
                                <label for="privacy_public" class="ml-2 block text-sm text-gray-900">Público</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="privacy" id="privacy_private" value="1"
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                        <?= $post['privacy'] == 1 ? 'checked' : '' ?>>
                                <label for="privacy_private" class="ml-2 block text-sm text-gray-900">Privado</label>
                            </div>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

<script>
    // Preview da nova imagem selecionada
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecione apenas arquivos de imagem.');
                event.target.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('A imagem deve ter no máximo 5MB.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('imagePreview');
                const container = document.getElementById('imagePreviewContainer');
                const imageName = document.getElementById('imageName');
                const buttonText = document.getElementById('imageButtonText');
                const currentImageContainer = document.getElementById('currentImageContainer');
                const removeInput = document.getElementById('remove_image');

                preview.src = e.target.result;
                container.classList.remove('hidden');
                imageName.textContent = file.name;
                buttonText.textContent = 'Alterar imagem';

                // Se selecionar nova imagem, remove a imagem atual
                if (currentImageContainer) {
                    // Remove visualmente a imagem atual
                    currentImageContainer.remove();

                    // Marca para substituir a imagem no backend
                    removeInput.value = '1';

                    // Mostra mensagem de aviso
                    const warningMsg = document.createElement('div');
                    warningMsg.id = 'replaceWarning';
                    warningMsg.className = 'mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800';
                    warningMsg.innerHTML = '💡 A imagem antiga será substituída pela nova ao salvar.';
                    container.before(warningMsg);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Remover a nova imagem selecionada (preview)
    function removeNewImage() {
        const input = document.getElementById('image');
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        const buttonText = document.getElementById('imageButtonText');
        const currentImageExists = document.getElementById('currentImageContainer') !== null;

        input.value = '';
        preview.src = '';
        container.classList.add('hidden');
        buttonText.textContent = currentImageExists ? 'Alterar imagem' : 'Adicionar imagem';
    }

    // Remover a imagem atual do post
    function removeCurrentImage() {
        if (confirm('Tem certeza que deseja remover a imagem atual? Esta ação não pode ser desfeita.')) {
            const container = document.getElementById('currentImageContainer');
            const buttonText = document.getElementById('imageButtonText');
            const removeInput = document.getElementById('remove_image');

            // Marca para remover a imagem no backend
            removeInput.value = '1';

            // Remove visualmente a imagem atual
            container.remove();

            // Atualiza o texto do botão
            buttonText.textContent = 'Adicionar imagem';

            // Mostra mensagem de sucesso
            const form = container.closest('form');
            const successMsg = document.createElement('div');
            successMsg.className = 'mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800';
            successMsg.innerHTML = '⚠️ A imagem será removida ao salvar a publicação.';
            form.querySelector('textarea').parentElement.after(successMsg);
        }
    }
</script>