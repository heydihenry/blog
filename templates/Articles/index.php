<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Article> $articles
 */
?>
<!-- templates/Articles/index.php -->
<div class="container mt-4">
    <!-- Header del Blog -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4">Mi Blog</h1>
            <div class="mb-3">
                <?php if ($this->Identity->isLoggedIn()): ?>
                    <?= $this->Html->link('Mis Artículos', ['action' => 'myArticles'], ['class'=>'btn btn-success']) ?>
                    <?= $this->Html->link('Crear Artículo', ['action' => 'add'], ['class'=>'btn btn-primary ms-2']) ?>
                <?php else: ?>
                    <?= $this->Html->link('Iniciar Sesión', ['controller' => 'Users', 'action' => 'login'], ['class'=>'btn btn-primary']) ?>
                <?php endif; ?>
                <?= $this->Html->link('Generar DBF', ['controller' => 'Dbf', 'action' => 'generate'], ['class' => 'btn btn-warning ms-2']) ?>
            </div>
            <p class="lead">Artículos recientes</p>
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
                        <?= h($article->category) ?>
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
                
                <!-- Footer de la tarjeta -->
                <div class="card-footer bg-white border-0 pb-3">
                    <?= $this->Html->link(
                        'Leer más →',
                        ['action' => 'view', $article->id],
                        ['class' => 'btn btn-outline-primary btn-sm']
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
        <h4 class="alert-heading">No hay artículos</h4>
        <p>Todavía no se han publicado artículos en el blog.</p>
    </div>
</div>
<?php endif; ?>