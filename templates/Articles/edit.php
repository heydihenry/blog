<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<!-- templates/Articles/add.php -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Tarjeta del formulario -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h4 mb-0">
                        <i class="bi bi-pencil-square"></i> Crear Nuevo Artículo
                    </h2>
                </div>
                
                <div class="card-body">
                    <?= $this->Form->create($article, [
                        'class' => 'needs-validation',
                        'novalidate' => true
                    ]) ?>
                    
                    <!-- Título -->
                    <div class="mb-3">
                        <?= $this->Form->control('title', [
                            'label' => 'Título del artículo',
                            'class' => 'form-control',
                            'placeholder' => 'Ingresa el título del artículo',
                            'required' => true
                        ]) ?>
                    </div>
                    
                    <!-- Categoría -->
                    <div class="mb-3">
                        <?= $this->Form->control('category_id', [
                            'label' => 'Categoría',
                            'type' => 'select',
                            'options' => $categorys,
                            'class' => 'form-select',
                            'required' => true,
                            'empty' => '-- Selecciona una categoría --'
                        ]) ?>
                    </div>
                    
                    <!-- Cuerpo del artículo -->
                    <div class="mb-4">
                        <?= $this->Form->control('body', [
                            'label' => 'Contenido del artículo',
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'rows' => 8,
                            'placeholder' => 'Escribe aquí el contenido de tu artículo...',
                            'required' => true
                        ]) ?>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between align-items-center">
                        <?= $this->Html->link(
                            '<i class="bi bi-arrow-left"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-outline-secondary', 'escape' => false]
                        ) ?>
                        
                        <?= $this->Form->button(
                            'Publicar Artículo',
                            ['class' => 'btn btn-primary px-4', 'escape' => false]
                        ) ?>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="alert alert-info mt-4 d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <div>
                    <strong>Consejo:</strong> Los artículos se publicarán inmediatamente después de crearlos.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS adicional para el formulario -->
<style>
    /* Estilos para los campos del formulario */
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    
    /* Estilos para las etiquetas */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    /* Estilos para el textarea */
    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }
    
    /* Animación para el botón de publicar */
    .btn-primary {
        transition: all 0.2s ease-in-out;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
    }
</style>
