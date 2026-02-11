<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!-- templates/layout/default.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Mi Blog
        <?= $this->fetch('title') ?>
    </title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <?= $this->Html->css('app') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <!-- Navbar simple -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <?= $this->Html->link(
                'Mi Blog',
                '/',
                ['class' => 'navbar-brand']
            ) ?>
            <div class="d-flex">
                <?php $user = $this->request->getAttribute('identity'); ?>
                <?php if ($user): ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-box-arrow-right"></i> Cerrar Sesión',
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['class' => 'btn btn-outline-light', 'escape' => false]
                    ) ?>
                <?php else: ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-person-plus"></i> Registro',
                        ['controller' => 'Users', 'action' => 'register'],
                        ['class' => 'btn btn-outline-light me-2', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión',
                        ['controller' => 'Users', 'action' => 'login'],
                        ['class' => 'btn btn-light', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer -->
    <footer class="mt-5 py-3 bg-light text-center">
        <div class="container">
            <p class="text-muted mb-0">Mi Blog &copy; <?= date('Y') ?></p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>
