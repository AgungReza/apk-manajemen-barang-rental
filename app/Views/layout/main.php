<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link href="<?= base_url('src\output.css') ?>" rel="stylesheet">
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex flex-col md:flex-row">
    <?= view('layout/sidebar') ?>
        <div class="flex-1 p-6 bg-gray-100">
            <?= view('layout/navbar') ?>
            <?= $this->renderSection('content') ?>
            <?= view('layout/footer') ?>
        </div>
    </div>
</body>
</html>
