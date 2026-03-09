<?php
/**
 * @var \App\View\AppView $this
 * @var int $recordCount
 */
?>
<!-- templates/Dbf/generate.php -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="display-5">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Generador de Archivo DBF
                </h1>
                <p class="lead text-muted">Ingresa los datos que deseas exportar a formato DBF</p>
                <hr>
            </div>

            <!-- Instrucciones -->
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle"></i>
                <strong>Instrucciones:</strong> Completa los campos con los datos que deseas incluir en el archivo DBF. 
                Al menos un registro debe tener un nombre. El ID se asignará automáticamente.
            </div>

            <!-- Selector de cantidad de registros -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="recordCountSelect" class="form-label">
                                <i class="bi bi-list"></i> Cantidad de Registros:
                            </label>
                            <select id="recordCountSelect" class="form-select" onchange="changeRecordCount()">
                                <option value="5" <?= $recordCount == 5 ? 'selected' : '' ?>>5 registros</option>
                                <option value="10" <?= $recordCount == 10 ? 'selected' : '' ?>>10 registros</option>
                                <option value="20" <?= $recordCount == 20 ? 'selected' : '' ?>>20 registros</option>
                                <option value="30" <?= $recordCount == 30 ? 'selected' : '' ?>>30 registros</option>
                                <option value="50" <?= $recordCount == 50 ? 'selected' : '' ?>>50 registros</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0 mt-2">
                                <small>Selecciona cuántas filas de entrada deseas ver</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <?= $this->Form->create(null, [
                'class' => 'needs-validation',
                'novalidate' => true,
                'method' => 'POST',
                'id' => 'dbfForm'
            ]) ?>

            <!-- Tabla de entrada de datos -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 8%;">ID</th>
                            <th style="width: 35%;">Nombre <span class="text-danger">*</span></th>
                            <th style="width: 35%;">Email</th>
                            <th style="width: 22%;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTable">
                        <?php for ($i = 0; $i < $recordCount; $i++): ?>
                        <tr class="record-row">
                            <td class="align-middle">
                                <span class="badge bg-secondary row-number"><?= $i + 1 ?></span>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.NAME', [
                                    'label' => false,
                                    'placeholder' => 'Ej: Juan Pérez',
                                    'class' => 'form-control',
                                    'required' => false
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.EMAIL', [
                                    'label' => false,
                                    'placeholder' => 'Ej: juan@example.com',
                                    'class' => 'form-control',
                                    'type' => 'email',
                                    'required' => false
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.CREATED', [
                                    'label' => false,
                                    'placeholder' => 'YYYY-MM-DD',
                                    'class' => 'form-control',
                                    'value' => date('Y-m-d'),
                                    'type' => 'date',
                                    'required' => false
                                ]) ?>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <!-- Información de campos -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información de Campos</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-2">ID</dt>
                        <dd class="col-sm-10">
                            Se asigna automáticamente según el orden de los registros. 
                            <small class="text-muted">(Numérico, máx 10 dígitos)</small>
                        </dd>
                        
                        <dt class="col-sm-2">Nombre <span class="text-danger">*</span></dt>
                        <dd class="col-sm-10">
                            Requerido si quieres incluir el registro. 
                            <small class="text-muted">(Texto, máx 50 caracteres)</small>
                        </dd>
                        
                        <dt class="col-sm-2">Email</dt>
                        <dd class="col-sm-10">
                            Campo adicional opcional. 
                            <small class="text-muted">(Texto, máx 100 caracteres)</small>
                        </dd>
                        
                        <dt class="col-sm-2">Fecha</dt>
                        <dd class="col-sm-10">
                            Formato ISO (YYYY-MM-DD), por defecto la fecha actual. 
                            <small class="text-muted">(Se convierte a YYYYMMDD en el DBF)</small>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4">
                <?= $this->Form->button(
                    '<i class="bi bi-download"></i> Descargar DBF',
                    [
                        'type' => 'submit',
                        'class' => 'btn btn-success btn-lg',
                        'escape' => false
                    ]
                ) ?>
                <?= $this->Html->link(
                    '<i class="bi bi-arrow-left"></i> Volver',
                    ['controller' => 'Articles', 'action' => 'index'],
                    [
                        'class' => 'btn btn-secondary btn-lg',
                        'escape' => false
                    ]
                ) ?>
            </div>

            <?= $this->Form->end() ?>

            <!-- Ejemplo de uso -->
            <div class="alert alert-secondary" role="alert">
                <h6 class="alert-heading"><i class="bi bi-lightbulb"></i> Consejo</h6>
                <small>
                    Los registros con campos <strong>Nombre</strong> vacíos serán ignorados automáticamente.<br>
                    El archivo se descargará en formato DBF compatible con dBase III.<br>
                    <strong>Nota:</strong> Los registros se numerarán secuencialmente en el ID independientemente de la fila.
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 0.25rem;
    }

    .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }

    .table input[type="text"],
    .table input[type="email"],
    .table input[type="date"] {
        font-size: 0.95rem;
        margin: 0;
    }

    .record-row {
        transition: background-color 0.2s;
    }

    .record-row:hover {
        background-color: #f8f9fa;
    }

    .row-number {
        font-weight: bold;
        font-size: 0.9rem;
    }

    .text-danger {
        color: #dc3545;
    }
</style>

<script>
function changeRecordCount() {
    const select = document.getElementById('recordCountSelect');
    const newCount = select.value;
    const currentUrl = window.location.pathname;
    window.location.href = currentUrl + '?rows=' + newCount;
}
</script>
