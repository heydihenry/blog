<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<!-- templates/Users/add.php -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Tarjeta de Registro -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h4 mb-0">
                        <i class="bi bi-person-plus"></i> Registrar Nuevo Usuario
                    </h2>
                </div>
                
                <div class="card-body">
                    <!-- Mensajes Flash -->
                    <?= $this->Flash->render() ?>
                    
                    <!-- Formulario de Registro -->
                    <?= $this->Form->create($user, [
                        'class' => 'needs-validation',
                        'novalidate' => true
                    ]) ?>
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'label' => 'Correo electrónico',
                            'type' => 'email',
                            'class' => 'form-control',
                            'placeholder' => 'tu@email.com',
                            'required' => true,
                            'autofocus' => true
                        ]) ?>
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-3">
                        <?= $this->Form->control('password', [
                            'label' => 'Contraseña',
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeholder' => '••••••••',
                            'required' => true
                        ]) ?>
                    </div>
                    
                    
                    
                    <!-- Botón de Registro -->
                    <div class="d-grid gap-2">
                        <?= $this->Form->button(
                            'Crear Cuenta',
                            ['class' => 'btn btn-primary py-2', 'escape' => false]
                        ) ?>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
            
            <!-- Enlaces adicionales -->
            <div class="text-center mt-4">
                <div class="card shadow-sm">
                    <div class="card-body py-3">
                        <p class="mb-0 text-muted">
                            ¿Ya tienes una cuenta?
                            <?= $this->Html->link(
                                'Inicia sesión aquí',
                                ['action' => 'login'],
                                ['class' => 'text-decoration-none']
                            ) ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Enlace para volver al blog -->
            <div class="text-center mt-3">
                <?= $this->Html->link(
                    '<i class="bi bi-arrow-left"></i> Volver al Blog',
                    ['controller' => 'Articles', 'action' => 'index'],
                    ['class' => 'text-decoration-none text-muted', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales (mismos que el login) -->
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .btn-primary {
        transition: all 0.2s ease-in-out;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
    }
    
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
        border-radius: 10px 10px 0 0 !important;
    }
    
    a {
        transition: color 0.2s ease-in-out;
    }
    
    a:hover {
        color: #0a58ca !important;
    }
    
    /* Estilo específico para el select */
    .form-select {
        background-color: #fff;
        cursor: pointer;
    }
    
    .form-select option {
        padding: 8px;
    }
</style>