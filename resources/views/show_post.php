<?php

use Random\RandomException;

$this->layout('layouts/master', ['title' => 'Post de ' . htmlspecialchars($post[0]['user_name'])]);

?>

<style>
    /* Estilo para limitar o tamanho da imagem da postagem */
    .post-image {
        max-width: 100%;
        max-height: 600px;
        width: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
    }

    /* CSS para o menu dropdown */
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

    /* CSS para o formulário de comentários */
    .comment-form {
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    .comment-form.show {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* CSS para área de comentários */
    .comment-item {
        transition: background-color 0.2s;
    }

    .comment-item:hover {
        background-color: #f9fafb;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 lg:gap-8">
        <main class="lg:col-span-3 lg:col-start-2 space-y-8">

            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">

                        <div class="flex items-center">
                            <?php
                            $avatarUrl = $post[0]['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($post[0]['user_name']) . '&background=random';
                            ?>
                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                 src="<?= htmlspecialchars($avatarUrl) ?>"
                                 alt="Avatar de <?= htmlspecialchars($post[0]['user_name']) ?>"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($post[0]['user_name']) ?>&background=random'">

                            <a href="/user/profile/<?= htmlspecialchars($post[0]['user_id']) ?>">
                                <div class="ml-4">
                                    <div class="text-lg font-bold text-gray-900 hover:underline"><?= htmlspecialchars($post[0]['user_name']) ?></div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span><?= htmlspecialchars($post[0]['date_formatado']) ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Menu Dropdown (só aparece para o dono do post) -->
                        <?php if ($post[0]['user_id'] == ($_SESSION['user']['user_id'] ?? null)) : ?>
                            <div class="dropdown-container">
                                <button onclick="toggleDropdown(event, 'dropdownMenu')"
                                        class="p-2 rounded-full hover:bg-gray-100 transition-colors"
                                        aria-label="Menu de opções">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>

                                <div id="dropdownMenu" class="dropdown-menu">
                                    <a href="/post/edit/<?= htmlspecialchars($post[0]['id']) ?>"
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                        <svg class="h-5 w-5 mr-3 text-blue-600" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="font-medium">Editar post</span>
                                    </a>

                                    <button onclick="confirmDelete('<?= htmlspecialchars($post[0]['id']) ?>')"
                                            class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors rounded-b-lg">
                                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <div class="px-6 pb-4">
                    <p class="text-gray-800 text-base">
                        <?= nl2br(htmlspecialchars($post[0]['content'])) ?>
                    </p>
                </div>

                <?php if (!empty($post[0]['image'])): ?>
                    <div class="bg-gray-100 p-2">
                        <img class="post-image"
                             src="data:image/jpeg;base64,<?= $post[0]['image'] ?>"
                             alt="Imagem da postagem"
                             loading="lazy">
                    </div>
                <?php endif; ?>

                <div class="p-4 flex justify-start space-x-6 border-t border-gray-200">
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="font-medium">Curtir</span>
                    </button>
                    <button onclick="toggleCommentForm()" class="flex items-center space-x-2 text-gray-600 hover:text-green-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span class="font-medium">Comentar</span>
                    </button>
                </div>

                <!-- Formulário de Comentários -->
                <div id="commentForm" class="comment-form border-t border-gray-200">
                    <form action="/comment/create" method="post" class="p-4">
                        <?php try {
                            echo getToken();
                        } catch (RandomException $e) {
                            // Tratar exceção se necessário
                        } ?>

                        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post[0]['id']) ?>">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user']['user_id'] ?? '') ?>">

                        <div class="flex items-start space-x-3">
                            <?php
                            $userAvatarUrl = $_SESSION['user']['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['user']['name'] ?? 'User') . '&background=random';
                            ?>
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200"
                                 src="<?= htmlspecialchars($userAvatarUrl) ?>"
                                 alt="Seu avatar">

                            <div class="flex-1">
                                <textarea
                                        name="content"
                                        rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                                        placeholder="Escreva um comentário..."
                                        required></textarea>
                                <?= flash('content', 'text-xs text-red-500 mt-1') ?>
                                <?= flash('error', 'text-xs text-red-500 mt-1') ?>

                                <div class="flex justify-end space-x-2 mt-2">
                                    <button
                                            type="button"
                                            onclick="toggleCommentForm()"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        Cancelar
                                    </button>
                                    <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                        Comentar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Área de Comentários -->
                <div class="border-t border-gray-200">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Comentários
                            <?php if (isset($comments) && count($comments) > 0): ?>
                                <span class="text-sm font-normal text-gray-500">(<?= count($comments) ?>)</span>
                            <?php endif; ?>
                        </h3>

                        <!-- Lista de Comentários -->
                        <?php if (isset($comments) && count($comments) > 0): ?>
                            <div class="space-y-4">
                                <?php foreach ($comments as $comment): ?>
                                    <div class="comment-item p-3 rounded-lg">
                                        <div class="flex items-start space-x-3">
                                            <?php
                                            $commentAvatarUrl = $comment['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment['user_name']) . '&background=random';
                                            ?>
                                            <img class="h-8 w-8 rounded-full object-cover border border-gray-200"
                                                 src="<?= htmlspecialchars($commentAvatarUrl) ?>"
                                                 alt="Avatar de <?= htmlspecialchars($comment['user_name']) ?>"
                                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($comment['user_name']) ?>&background=random'">

                                            <div class="flex-1 min-w-0">
                                                <div class="bg-gray-50 rounded-lg px-4 py-2">
                                                    <a href="/user/profile/<?= htmlspecialchars($comment['user_id']) ?>"
                                                       class="font-semibold text-sm text-gray-900 hover:underline">
                                                        <?= htmlspecialchars($comment['user_name']) ?>
                                                    </a>
                                                    <p class="text-sm text-gray-800 mt-1">
                                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                                    </p>
                                                </div>
                                                <div class="flex items-center space-x-4 mt-1 ml-4">
                                                    <span class="text-xs text-gray-500">
                                                        <?= htmlspecialchars($comment['date_formatado']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Nenhum comentário ainda.</p>
                                <p class="text-sm text-gray-500">Seja o primeiro a comentar!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Toggle do menu dropdown
    function toggleDropdown(event, menuId) {
        event.stopPropagation();

        // Fechar todos os outros dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== menuId) {
                menu.classList.remove('show');
            }
        });

        // Toggle do dropdown clicado
        const menu = document.getElementById(menuId);
        if (menu) {
            menu.classList.toggle('show');
        }
    }

    // Toggle do formulário de comentários
    function toggleCommentForm() {
        const form = document.getElementById('commentForm');
        if (form) {
            form.classList.toggle('show');

            // Focar no textarea quando abrir
            if (form.classList.contains('show')) {
                const textarea = form.querySelector('textarea[name="content"]');
                if (textarea) {
                    textarea.focus();
                }
            }
        }
    }

    // Fechar dropdown ao clicar fora
    window.addEventListener('click', function(event) {
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
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Fechar formulário de comentários também
            const commentForm = document.getElementById('commentForm');
            if (commentForm && commentForm.classList.contains('show')) {
                commentForm.classList.remove('show');
            }
        }
    });
</script>