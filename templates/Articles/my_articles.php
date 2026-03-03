<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Article> $articles
 */
?>
<!-- templates/Articles/my_articles.php -->
<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4">Mis Artículos</h1>
            <?= $this->Html->link('Crear Nuevo Artículo', ['action' => 'add'], ['class'=>'btn btn-primary']) ?>
            <?= $this->Html->link('Volver al Blog', ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
            <p class="lead">Gestiona tus artículos publicados</p>
            <hr class="my-4">
        </div>
    </div>

    <!-- Lista de Artículos -->
    <div class="row">
        <?php foreach ($articles as $article): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <!-- Categoría -->
                    <span class="badge bg-primary mb-2">
                        <?= h($article->category->name ?? 'Sin categoría') ?>
                    </span>
                    
                    <!-- Título -->
                    <h2 class="card-title h4">
                        <?= $this->Html->link(
                            h($article->title),
                            ['action' => 'view', $article->id],
                            ['class' => 'text-decoration-none']
                        ) ?>
                    </h2>
                    
                    <!-- Fecha de creación -->
                    <div class="text-muted small mb-2">
                        <i class="bi bi-calendar"></i> 
                        <?= $article->created->format('d/m/Y H:i') ?>
                    </div>
                    
                    <!-- Cuerpo del artículo (extracto) -->
                    <p class="card-text">
                        <?= $this->Text->truncate(
                            h($article->body),
                            200,
                            ['ellipsis' => '...', 'exact' => false]
                        ) ?>
                    </p>
                </div>
                
                <!-- Footer de la tarjeta con acciones -->
                <div class="card-footer bg-white border-0 pb-3">
                    <?= $this->Html->link(
                        'Leer →',
                        ['action' => 'view', $article->id],
                        ['class' => 'btn btn-outline-primary btn-sm']
                    ) ?>
                    <?= $this->Html->link(
                        'Editar',
                        ['action' => 'edit', $article->id],
                        ['class' => 'btn btn-outline-warning btn-sm']
                    ) ?>
                    <?= $this->Form->postLink(
                        'Eliminar',
                        ['action' => 'delete', $article->id],
                        ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-outline-danger btn-sm']
                    ) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <?php if ($this->Paginator->total() > 1): ?>
    <div class="row mt-4">
        <div class="col">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?= $this->Paginator->prev('← Anterior', ['class' => 'page-item', 'escape' => false]) ?>
                    <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
                    <?= $this->Paginator->next('Siguiente →', ['class' => 'page-item', 'escape' => false]) ?>
                </ul>
            </nav>
            <p class="text-center text-muted small">
                <?= $this->Paginator->counter('Página {{page}} de {{pages}}') ?>
            </p>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Si no hay artículos -->
<?php if (count($articles) == 0): ?>
<div class="container mt-4">
    <div class="alert alert-info text-center" role="alert">
        <h4 class="alert-heading">No tienes artículos creados</h4>
        <p>Comienza creando tu primer artículo haciendo clic en el botón "Crear Nuevo Artículo".</p>
        <?= $this->Html->link('Crear Artículo', ['action' => 'add'], ['class' => 'btn btn-primary mt-3']) ?>
    </div>
</div>
<?php endif; ?>
