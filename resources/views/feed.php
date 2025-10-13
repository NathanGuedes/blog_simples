<?php use Random\RandomException;

$this->layout('layouts/master', ['title' => 'Feed']) ?>

<style>
    .post-image {
        max-width: 100%;
        max-height: 500px;
        width: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        min-width: 200px;
        z-index: 50;
        border: 1px solid #e5e7eb;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-container {
        position: relative;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 lg:gap-8">

        <main class="lg:col-span-3 lg:col-start-2 space-y-8">

            <!-- Formulário de Criação de Post -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Criar Publicação</h2>
                </div>

                <form action="/posts/create" method="post" class="space-y-4" enctype="multipart/form-data">
                    <?php try {
                        echo getToken();
                    } catch (RandomException $e) {
                        // Tratar exceção se necessário
                    } ?>
                    <?= flash('error', 'text-xs text-red-500') ?>

                    <div>
                        <label for="content" class="sr-only">Conteúdo</label>
                        <textarea name="content" id="content" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="No que você está pensando?"><?= isset($_SESSION['__flash']['content']) ? flashOld('contentField') : '' ?></textarea>
                    </div>
                    <?= flash('content', 'text-xs text-red-500') ?>

                    <!-- Preview da Imagem -->
                    <div id="imagePreviewContainer" class="hidden">
                        <div class="relative inline-block">
                            <img id="imagePreview" src="" alt="Preview"
                                 class="max-h-48 rounded-lg border-2 border-gray-300">
                            <button type="button" onclick="removeImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors shadow-lg">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <p id="imageName" class="text-sm text-gray-600 mt-2"></p>
                    </div>

                    <div class="flex flex-wrap justify-between items-center pt-2 gap-4">
                        <div>
                            <label for="image"
                                   class="cursor-pointer text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span id="imageButtonText">Imagem</span>
                            </label>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*"
                                   onchange="previewImage(event)">
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="radio" name="privacy" id="privacy_public" value="0"
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                <label for="privacy_public" class="ml-2 block text-sm text-gray-900">Público</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="privacy" id="privacy_private" value="1"
                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <label for="privacy_private" class="ml-2 block text-sm text-gray-900">Privado</label>
                            </div>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Publicar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de Posts -->
            <?php foreach ($posts as $post): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <!-- Cabeçalho do Post -->
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <?php
                                $avatarUrl = $post['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($post['user_name']) . '&background=random';
                                ?>
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                     src="<?= htmlspecialchars($avatarUrl) ?>"
                                     alt="Avatar de <?= htmlspecialchars($post['user_name']) ?>"
                                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($post['user_name']) ?>&background=random'">
                                <a href="user/profile/<?= $post['user_id']?>">
                                    <div class="ml-4">
                                        <div class="text-lg font-bold text-gray-900 hover:underline"><?= htmlspecialchars($post['user_name']) ?></div>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span><?= htmlspecialchars($post['date_formatado']) ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Menu Dropdown (só aparece para o dono do post) -->
                            <?php if ($post['user_id'] == ($_SESSION['user']['user_id'] ?? null)) : ?>
                                <div class="dropdown-container">
                                    <button onclick="toggleDropdown(event, 'dropdown-<?= htmlspecialchars($post['id']) ?>')"
                                            class="p-2 rounded-full hover:bg-gray-100 transition-colors"
                                            aria-label="Menu de opções">
                                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </button>

                                    <div id="dropdown-<?= htmlspecialchars($post['id']) ?>" class="dropdown-menu">
                                        <a href="/post/edit/<?= htmlspecialchars($post['id']) ?>"
                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                            <svg class="h-5 w-5 mr-3 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="font-medium">Editar post</span>
                                        </a>

                                        <button onclick="confirmDelete('<?= htmlspecialchars($post['id']) ?>')"
                                                class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors rounded-b-lg">
                                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="font-medium">Deletar post</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Conteúdo do Post -->
                    <a href="/post/<?= htmlspecialchars($post['id']) ?>">
                        <div class="px-6 pb-4">
                            <p class="text-gray-800 text-base">
                                <?= nl2br(htmlspecialchars($post['content'])) ?>
                            </p>
                        </div>
                        <?php if (!empty($post['image'])): ?>
                            <div class="bg-gray-100 p-2">
                                <img class="post-image"
                                     src="data:image/jpeg;base64,<?= $post['image']?>"
                                     alt="Imagem da postagem"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>
                    </a>

                    <!-- Ações do Post -->
                    <div class="p-4 flex justify-start space-x-6 border-t border-gray-200">
                        <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>Curtir</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-600 hover:text-green-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>Comentar</span>
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>

        </main>

    </div>
</div>

<script>
    // Preview da imagem selecionada
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Validar tipo de arquivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecione apenas arquivos de imagem.');
                event.target.value = '';
                return;
            }

            // Validar tamanho (5MB)
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

                preview.src = e.target.result;
                container.classList.remove('hidden');
                imageName.textContent = file.name;
                buttonText.textContent = 'Alterar Imagem';
            };
            reader.readAsDataURL(file);
        }
    }

    // Remover imagem selecionada
    function removeImage() {
        const input = document.getElementById('image');
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        const buttonText = document.getElementById('imageButtonText');

        input.value = '';
        preview.src = '';
        container.classList.add('hidden');
        buttonText.textContent = 'Imagem';
    }

    // Toggle do menu dropdown
    function toggleDropdown(event, menuId) { // Simplified: Removed redundant variable assignment
        event.stopPropagation();

        // Fechar todos os outros dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== menuId) {
                menu.classList.remove('show');
            }
        });

        // Toggle do dropdown clicado
        document.getElementById(menuId)?.classList.toggle('show'); // Simplified: Optional chaining and direct toggle
    }

    // Fechar dropdown ao clicar fora
    window.addEventListener('click', function (event) {
        if (!event.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Confirmação antes de deletar
    function confirmDelete(post_id) {
        if (confirm('Tem certeza que deseja deletar este post? Esta ação não pode ser desfeita.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/post/delete/' + post_id;

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            // Adicionar token CSRF se disponível
            const csrfToken = document.querySelector('input[name="csrf_token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                csrfInput.value = csrfToken.value;
                form.appendChild(csrfInput);
            }

            document.body.appendChild(form);
            form.submit();
        }
    }

    // Fechar dropdowns ao pressionar ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
</script>