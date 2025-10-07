<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $this->e($title ?? 'Área de Autenticação') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<main>
    <?= $this->section('content') ?>
</main>
</body>
</html>
