<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->e($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?= $this->insert('partials/navbar') ?>
<main>
    <?= $this->section('content') ?>
</main>
<?= $this->insert('partials/footer') ?>
</body>
</html>