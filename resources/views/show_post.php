<?php

use Random\RandomException;

$this->layout('layouts/master', ['title' => 'Post de ' . htmlspecialchars($post[0]['user_name'])]);

?>

<style>
    /* =================================
       Estilos Gerais e Layout
    ==================================== */
    body {
        background-color: #f9fafb; /* Equivalente a bg-gray-50 */
    }

    .page-container {
        max-width: 1280px; /* max-w-7xl */
        margin: 0 auto;
        padding: 2rem 1rem; /* py-8 px-4 */
    }

    @media (min-width: 640px) {
        .page-container {
            padding-left: 1.5rem; /* sm:px-6 */
            padding-right: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .page-container {
            padding-left: 2rem; /* lg:px-8 */
            padding-right: 2rem;
        }
    }

    .grid-layout {
        display: grid;
        grid-template-columns: 1fr;
    }

    @media (min-width: 1024px) {
        .grid-layout {
            grid-template-columns: repeat(5, 1fr); /* lg:grid-cols-5 */
            gap: 2rem; /* lg:gap-8 */
        }
    }

    .main-content {
        /* Seletor para espaçamento entre filhos diretos */
        & > * + * {
            margin-top: 2rem; /* space-y-8 */
        }
    }

    @media (min-width: 1024px) {
        .main-content {
            grid-column: span 3 / span 3; /* lg:col-span-3 */
            grid-column-start: 2; /* lg:col-start-2 */
        }
    }

    /* =================================
       Card da Postagem
    ==================================== */
    .post-card {
        background-color: white;
        border-radius: 0.75rem; /* rounded-xl */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
        overflow: hidden;
        border: 1px solid #e5e7eb; /* border border-gray-200 */
    }

    .post-card-padding {
        padding: 1.5rem; /* p-6 */
    }

    .post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info a {
        text-decoration: none;
        color: inherit;
    }

    .user-avatar {
        height: 3rem; /* h-12 */
        width: 3rem; /* w-12 */
        border-radius: 9999px; /* rounded-full */
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .user-details {
        margin-left: 1rem; /* ml-4 */
    }

    .user-name {
        font-size: 1.125rem; /* text-lg */
        font-weight: 700; /* font-bold */
        color: #111827; /* text-gray-900 */
        transition: text-decoration 0.2s;
    }

    .user-name:hover {
        text-decoration: underline; /* hover:underline */
    }

    .post-date {
        display: flex;
        align-items: center;
        font-size: 0.875rem; /* text-sm */
        color: #6b7280; /* text-gray-500 */
    }

    /* Estilo para limitar o tamanho da imagem da postagem */
    .post-image-container {
        background-color: #f3f4f6; /* bg-gray-100 */
        padding: 0.5rem; /* p-2 */
    }
    .post-image {
        max-width: 100%;
        max-height: 600px;
        width: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
    }

    .post-content-wrapper {
        padding: 0 1.5rem 1rem; /* px-6 pb-4 */
    }

    .post-content-text {
        color: #1f2937; /* text-gray-800 */
        font-size: 1rem; /* text-base */
    }

    /* =================================
       Ações da Postagem (Curtir, Comentar)
    ==================================== */
    .post-actions {
        padding: 1rem; /* p-4 */
        display: flex;
        justify-content: flex-start;
        gap: 1.5rem; /* space-x-6 */
        border-top: 1px solid #e5e7eb; /* border-t border-gray-200 */
    }

    .action-button {
        display: flex;
        align-items: center;
        gap: 0.5rem; /* space-x-2 */
        color: #4b5563; /* text-gray-600 */
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.2s;
        font-weight: 500; /* font-medium */
    }

    .action-button:hover {
        color: #2563eb; /* hover:text-blue-600 */
    }

    .action-button.comment:hover {
        color: #16a34a; /* hover:text-green-600 */
    }

    .action-button svg {
        height: 1.5rem; /* h-6 */
        width: 1.5rem; /* w-6 */
    }

    /* =================================
       Menu Dropdown
    ==================================== */
    .dropdown-container {
        position: relative;
    }
    .dropdown-toggle {
        padding: 0.5rem; /* p-2 */
        border-radius: 9999px; /* rounded-full */
        transition: background-color 0.2s;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }
    .dropdown-toggle:hover {
        background-color: #f3f4f6; /* hover:bg-gray-100 */
    }
    .dropdown-toggle svg {
        height: 1.5rem; /* h-6 */
        width: 1.5rem; /* w-6 */
        color: #4b5563; /* text-gray-600 */
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
    .dropdown-item {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 0.75rem 1rem; /* px-4 py-3 */
        font-size: 0.875rem; /* text-sm */
        transition: background-color 0.2s;
        text-decoration: none;
        border: none;
        background-color: transparent;
        cursor: pointer;
        text-align: left;
    }
    .dropdown-item span {
        font-weight: 500; /* font-medium */
    }
    .dropdown-item svg {
        height: 1.25rem; /* h-5 */
        width: 1.25rem; /* w-5 */
        margin-right: 0.75rem; /* mr-3 */
    }
    .dropdown-item.edit {
        color: #374151; /* text-gray-700 */
        border-bottom: 1px solid #f3f4f6; /* border-b border-gray-100 */
    }
    .dropdown-item.edit svg { color: #2563eb; /* text-blue-600 */ }
    .dropdown-item.edit:hover { background-color: #f9fafb; /* hover:bg-gray-50 */ }
    .dropdown-item.delete {
        color: #dc2626; /* text-red-600 */
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    .dropdown-item.delete:hover { background-color: #fee2e2; /* hover:bg-red-50 */ }


    /* =================================
       Formulário e Área de Comentários
    ==================================== */
    .comment-form-wrapper {
        display: none;
        animation: slideDown 0.3s ease-out;
        border-top: 1px solid #e5e7eb;
    }
    .comment-form-wrapper.show {
        display: block;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .comment-form {
        padding: 1rem;
    }
    .comment-form-inner {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .comment-form-avatar {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    .comment-form-input-wrapper {
        flex: 1;
    }
    .comment-textarea {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        resize: none;
        transition: box-shadow 0.2s, border-color 0.2s;
    }
    .comment-textarea:focus {
        outline: none;
        border-color: transparent;
        box-shadow: 0 0 0 2px #22c55e; /* focus:ring-2 focus:ring-green-500 */
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-primary {
        color: white;
        background-color: #16a34a; /* bg-green-600 */
    }
    .btn-primary:hover {
        background-color: #15803d; /* hover:bg-green-700 */
    }
    .btn-secondary {
        color: #374151;
        background-color: #f3f4f6; /* bg-gray-100 */
    }
    .btn-secondary:hover {
        background-color: #e5e7eb; /* hover:bg-gray-200 */
    }
    .flash-message {
        font-size: 0.75rem; /* text-xs */
        color: #ef4444; /* text-red-500 */
        margin-top: 0.25rem; /* mt-1 */
    }

    /* Lista de Comentários */
    .comments-area {
        border-top: 1px solid #e5e7eb;
        padding: 1rem;
    }
    .comments-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }
    .comments-count {
        font-size: 0.875rem;
        font-weight: 400;
        color: #6b7280;
    }
    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .comment-item {
        padding: 0.75rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s;
    }
    .comment-item:hover {
        background-color: #f9fafb;
    }
    .comment-item-inner {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .comment-avatar {
        height: 2rem;
        width: 2rem;
        border-radius: 9999px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }
    .comment-body {
        flex: 1;
        min-width: 0;
    }
    .comment-content-wrapper {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }
    .comment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .comment-author {
        font-weight: 600;
        font-size: 0.875rem;
        color: #111827;
        text-decoration: none;
    }
    .comment-author:hover {
        text-decoration: underline;
    }
    .comment-text {
        font-size: 0.875rem;
        color: #1f2937;
        margin-top: 0.25rem;
    }
    .comment-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.25rem;
        margin-left: 1rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
    .comment-dropdown-toggle {
        padding: 0.25rem;
        border-radius: 9999px;
        background: transparent;
        border: none;
        cursor: pointer;
    }
    .comment-dropdown-toggle:hover { background-color: #e5e7eb; }
    .comment-dropdown-toggle svg { height: 1rem; width: 1rem; color: #4b5563; }
    .comment-dropdown-item-edit svg { color: #2563eb; }
    .comment-dropdown-item-edit {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
    .comment-dropdown-item-delete {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
    .comment-dropdown-item-edit svg, .comment-dropdown-item-delete svg {
        height: 1rem; width: 1rem; margin-right: 0.5rem;
    }

    /* Formulário de Edição de Comentário */
    .edit-comment-form {
        display: none;
        animation: slideDown 0.3s ease-out;
    }
    .edit-comment-form.show {
        display: block;
    }
    .edit-comment-form .form-container {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 0.75rem;
    }
    .edit-comment-textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        resize: none;
        font-size: 0.875rem;
    }
    .edit-comment-textarea:focus {
        outline: none;
        border-color: transparent;
        box-shadow: 0 0 0 2px #3b82f6; /* focus:ring-blue-500 */
    }
    .edit-comment-form .form-actions {
        margin-top: 0.5rem;
    }
    .btn-small {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
    .btn-small.btn-primary { background-color: #2563eb; } /* bg-blue-600 */
    .btn-small.btn-primary:hover { background-color: #1d4ed8; } /* hover:bg-blue-700 */
    .btn-small.btn-secondary { background-color: #e5e7eb; } /* bg-gray-200 */
    .btn-small.btn-secondary:hover { background-color: #d1d5db; } /* hover:bg-gray-300 */

    /* Bloco "Nenhum Comentário" */
    .no-comments {
        text-align: center;
        padding: 2rem 0;
    }
    .no-comments svg {
        margin: 0 auto;
        height: 3rem;
        width: 3rem;
        color: #9ca3af; /* text-gray-400 */
    }
    .no-comments p {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280; /* text-gray-500 */
    }

    /* Utilitários */
    .comment-content { display: block; }
    .comment-content.hidden { display: none; }
</style>

<div class="page-container">
    <div class="grid-layout">
        <main class="main-content">

            <div class="post-card">
                <div class="post-card-padding">
                    <div class="post-header">

                        <div class="user-info">
                            <?php
                            $avatarUrl = $post[0]['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($post[0]['user_name']) . '&background=random';
                            ?>
                            <img class="user-avatar"
                                 src="<?= htmlspecialchars($avatarUrl) ?>"
                                 alt="Avatar de <?= htmlspecialchars($post[0]['user_name']) ?>"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($post[0]['user_name']) ?>&background=random'">

                            <a href="/user/profile/<?= htmlspecialchars($post[0]['user_id']) ?>">
                                <div class="user-details">
                                    <div class="user-name"><?= htmlspecialchars($post[0]['user_name']) ?></div>
                                    <div class="post-date">
                                        <span><?= htmlspecialchars($post[0]['date_formatado']) ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php if ($post[0]['user_id'] == ($_SESSION['user']['user_id'] ?? null)) : ?>
                            <div class="dropdown-container">
                                <button onclick="toggleDropdown(event, 'dropdownMenu')"
                                        class="dropdown-toggle"
                                        aria-label="Menu de opções">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>

                                <div id="dropdownMenu" class="dropdown-menu">
                                    <a href="/post/edit/<?= htmlspecialchars($post[0]['id']) ?>" class="dropdown-item edit">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Editar post</span>
                                    </a>
                                    <button onclick="confirmDelete('<?= htmlspecialchars($post[0]['id']) ?>')" class="dropdown-item delete">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Deletar post</span>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="post-content-wrapper">
                    <p class="post-content-text">
                        <?= nl2br(htmlspecialchars($post[0]['content'])) ?>
                    </p>
                </div>

                <?php if (!empty($post[0]['image'])): ?>
                    <div class="post-image-container">
                        <img class="post-image"
                             src="data:image/jpeg;base64,<?= $post[0]['image'] ?>"
                             alt="Imagem da postagem"
                             loading="lazy">
                    </div>
                <?php endif; ?>

                <div class="post-actions">
                    <button class="action-button">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span>Curtir</span>
                    </button>
                    <button onclick="toggleCommentForm()" class="action-button comment">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Comentar</span>
                    </button>
                </div>

                <div id="commentForm" class="comment-form-wrapper">
                    <form action="/comment/create" method="post" class="comment-form">
                        <?php try { echo getToken(); } catch (RandomException $e) { /* Tratar exceção */ } ?>
                        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post[0]['id']) ?>">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user']['user_id'] ?? '') ?>">

                        <div class="comment-form-inner">
                            <?php $userAvatarUrl = $_SESSION['user']['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['user']['name'] ?? 'User') . '&background=random'; ?>
                            <img class="comment-form-avatar"
                                 src="<?= htmlspecialchars($userAvatarUrl) ?>"
                                 alt="Seu avatar">
                            <div class="comment-form-input-wrapper">
                                <textarea name="content" rows="3" class="comment-textarea" placeholder="Escreva um comentário..." required></textarea>
                                <?= flash('content', 'flash-message') ?>
                                <?= flash('error', 'flash-message') ?>
                                <div class="form-actions">
                                    <button type="button" onclick="toggleCommentForm()" class="btn btn-secondary">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Comentar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="comments-area">
                    <h3 class="comments-title">
                        Comentários
                        <?php if (isset($comments) && count($comments) > 0): ?>
                            <span class="comments-count">(<?= count($comments) ?>)</span>
                        <?php endif; ?>
                    </h3>

                    <?php if (isset($comments) && count($comments) > 0): ?>
                        <div class="comments-list">
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment-item">
                                    <div class="comment-item-inner">
                                        <?php $commentAvatarUrl = $comment['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment['user_name']) . '&background=random'; ?>
                                        <img class="comment-avatar"
                                             src="<?= htmlspecialchars($commentAvatarUrl) ?>"
                                             alt="Avatar de <?= htmlspecialchars($comment['user_name']) ?>"
                                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($comment['user_name']) ?>&background=random'">

                                        <div class="comment-body">
                                            <div id="comment-content-<?= $comment['comment_id'] ?>" class="comment-content">
                                                <div class="comment-content-wrapper">
                                                    <div class="comment-header">
                                                        <a href="/user/profile/<?= htmlspecialchars($comment['user_id']) ?>" class="comment-author">
                                                            <?= htmlspecialchars($comment['user_name']) ?>
                                                        </a>
                                                        <?php if (($comment['user_id'] == $_SESSION['user']['user_id']) || ($post[0]['user_id'] == $_SESSION['user']['user_id'] ?? null)): ?>
                                                            <div class="dropdown-container">
                                                                <button onclick="toggleDropdown(event, 'commentDropdown<?= $comment['comment_id'] ?>')" class="comment-dropdown-toggle" aria-label="Menu de opções do comentário">
                                                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                                    </svg>
                                                                </button>
                                                                <div id="commentDropdown<?= $comment['comment_id'] ?>" class="dropdown-menu">
                                                                    <?php if (($comment['user_id'] == $_SESSION['user']['user_id'])?? false):?>
                                                                        <button onclick="toggleEditComment(<?= $comment['comment_id'] ?>)" class="dropdown-item comment-dropdown-item-edit">
                                                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                            <span>Editar</span>
                                                                        </button>
                                                                    <?php endif ?>
                                                                    <form action="/comment/delete/<?= $comment['comment_id']?>" method="post">
                                                                        <input type="hidden" name="post_id" value="<?= $post[0]['id'] ?>">
                                                                        <input type="hidden" name="post_owner_id" value="<?= $post[0]['user_id'] ?>">
                                                                        <input type="hidden" name="comment_owner_id" value="<?= $comment['user_id'] ?>">
                                                                        <button type="submit" class="dropdown-item delete comment-dropdown-item-delete">
                                                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                            <span>Excluir</span>
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="comment-text">
                                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                                    </p>
                                                </div>
                                                <div class="comment-meta">
                                                    <span><?= htmlspecialchars($comment['date_formatado']) ?></span>
                                                </div>
                                            </div>

                                            <div id="edit-comment-form-<?= $comment['comment_id'] ?>" class="edit-comment-form">
                                                <form action="/comment/update/<?= $comment['comment_id'] ?>" method="post">
                                                    <input type="hidden" name="post_id" value="<?= $post[0]['id']?>">
                                                    <input type="hidden" name="comment_owner_id" value="<?= $comment['user_id'] ?>">
                                                    <input type="hidden" name="id" value="<?= $comment['comment_id'] ?>">
                                                    <div class="form-container">
                                                        <label>
                                                            <textarea name="content" rows="3" class="edit-comment-textarea" required><?= htmlspecialchars($comment['content']) ?></textarea>
                                                        </label>
                                                        <div class="form-actions">
                                                            <button type="button" onclick="toggleEditComment(<?= $comment['comment_id'] ?>)" class="btn btn-small btn-secondary">Cancelar</button>
                                                            <button type="submit" class="btn btn-small btn-primary">Salvar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-comments">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p>Nenhum comentário ainda.</p>
                            <p>Seja o primeiro a comentar!</p>
                        </div>
                    <?php endif; ?>
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

    // Toggle do formulário de edição de comentário
    function toggleEditComment(commentId) {
        const contentDiv = document.getElementById('comment-content-' + commentId);
        const editForm = document.getElementById('edit-comment-form-' + commentId);

        if (contentDiv && editForm) {
            contentDiv.classList.toggle('hidden');
            editForm.classList.toggle('show');

            // Focar no textarea quando abrir
            if (editForm.classList.contains('show')) {
                const textarea = editForm.querySelector('textarea[name="content"]');
                if (textarea) {
                    textarea.focus();
                    // Colocar cursor no final do texto
                    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                }
            }
        }

        // Fechar o dropdown
        const dropdown = document.getElementById('commentDropdown' + commentId);
        if (dropdown) {
            dropdown.classList.remove('show');
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

    // Confirmação antes de deletar post
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

            document.body.appendChild(form);
            form.submit();
        }
    }

    // Confirmação antes de deletar comentário
    function confirmDeleteComment(commentId) {
        if (confirm('Tem certeza que deseja excluir este comentário? Esta ação não pode ser desfeita.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/comment/delete/' + commentId;

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

    // Fechar dropdowns e formulários ao pressionar ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            // Fechar todos os dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Fechar formulário de comentários
            const commentForm = document.getElementById('commentForm');
            if (commentForm && commentForm.classList.contains('show')) {
                commentForm.classList.remove('show');
            }

            // Fechar todos os formulários de edição de comentários
            document.querySelectorAll('.edit-comment-form.show').forEach(form => {
                const commentId = form.id.replace('edit-comment-form-', '');
                toggleEditComment(commentId);
            });
        }
    });
</script>