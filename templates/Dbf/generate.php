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

            <!-- Seccion para editar los datos del formulario -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4">
                <?= $this->Form->button(
                    'Cargar Datos',
                    [
                        'type' => 'button',
                        'style' => 'background-color: #b23',
                        'class' => 'btn btn-secondary btn-ms',
                    ]
                ) ?> 
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
                <table style="border: 0;"
                    class="">
                    <thead style="border-bottom: 1px solid; margin-bottom: 5px;"
                        class="theader">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Carnet</th>
                            <th style="width: 35%;">Nombre</th>
                            <th style="width: 25%;">Cuenta</th>
                            <th style="width: 20%;">Importe</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTable">
                        <?php 
                        $recordCount = 1;
                        for ($i = 0; $i < $recordCount; $i++): ?>
                        <tr class="record-row">
                            <td class="align-middle">
                                <span
                                    class="row-number"><?= $i + 1 ?></span>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.CARNET', [
                                    'label' => false,
                                    'placeholder' => 'Ej: 000101...',
                                    'class' => '',
                                    'required' => false,
                                    'type' => 'number',
                                    'minlength' => 11,
                                    'maxlenght' => 11,
                                    'style' => 'width: 100%'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.NOMBRE', [
                                    'label' => false,
                                    'placeholder' => 'Ej: Juan Enrique...',
                                    'class' => '',
                                    'required' => false,
                                    'type' => 'text',
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.CUENTA', [
                                    'label' => false,
                                    'placeholder' => 'Ej: 05987...',
                                    'class' => '',
                                    'type' => 'number',
                                    'required' => false,
                                    'minlength' => 16,
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . $i . '.IMPORTE', [
                                    'label' => false,
                                    'placeholder' => '0.00',
                                    'class' => '',
                                    'type' => 'number',
                                    'required' => false,
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botones de acción -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-4">
                <?= $this->Form->button(
                    'Añadir Fila',
                    [
                        'type' => 'button',
                        'style' => 'background-color: #26b',
                        'class' => 'btn btn-secondary btn-ms',
                        'id' => 'addRowBtn'
                    ]
                ) ?>
                <?= $this->Form->button(
                    'Descargar DBF',
                    [
                        'type' => 'submit',
                        'class' => 'btn btn-success btn-ms',
                        'escape' => false,
                    ]
                ) ?>
                <?= $this->Html->link(
                    '<i class="bi bi-arrow-left"></i> Volver',
                    ['controller' => 'Articles', 'action' => 'index'],
                    [
                        'class' => 'btn btn-secondary btn-ms',
                        'escape' => false
                    ]
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 0.25rem;
    }

    .recordsTable {
        width: 100%;
    }

    .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }

    .table input,
    .table input::placeholder {
        font-size: 0.95rem;
        margin: 0;
    }

    .record-row {
        width: 100%;
        height: min-content;
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

    @media screen and (width <= 425px) {
        .table-responsive {
            font-size: 0.7rem;
        }
        .table input,
        .table input::placeholder {
            padding: 2px 1px;
            margin: 5px;
        }
        .row-number {
            font-size: 0.7rem;
        }
        .theader {
            text-align: center;
        }
        .record-row {
            height: 25px;
        }
    }
</style>

<!-- Script para añadir filas dinámicamente -->
<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRowBtn = document.getElementById('addRowBtn');
        const tbody = document.getElementById('recordsTable');
                            
        // Función para obtener el número actual de filas
        function getRowCount() {
            return tbody.querySelectorAll('tr.record-row').length;
        }

        // Función para actualizar los números de fila (columna No)
        function updateRowNumbers() {
            const rows = tbody.querySelectorAll('tr.record-row');
            rows.forEach((row, index) => {
                const span = row.querySelector('.row-number');
                if (span) {
                    span.textContent = index + 1;
                }
            });
        }

        // Función para añadir una nueva fila
        function addRow() {
            const newIndex = getRowCount(); // el índice para el nuevo registro
            // Crear la fila
            const tr = document.createElement('tr');
            tr.className = 'record-row';
            tr.style.marginTop = '5px';
                            
            // Columna No
            const tdNo = document.createElement('td');
            tdNo.className = 'align-middle';
            const span = document.createElement('span');
            span.className = 'row-number';
            span.textContent = newIndex + 1; // número visible
            tdNo.appendChild(span);
            tr.appendChild(tdNo);
                            
            // Columna Carnet
            const tdCarnet = document.createElement('td');
            tdCarnet.innerHTML = `<?= $this->Form->control('records.INDEX.CARNET', [
                'label' => false,
                'placeholder' => 'Ej:000101...',
                'class' => '',
                'required' => false,
                'type' => 'number',
                'minlength' => 13,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdCarnet);
                            
            // Columna Nombre
            const tdNombre = document.createElement('td');
            tdNombre.innerHTML = `<?= $this->Form->control('records.INDEX.NOMBRE', [
                'label' => false,
                'placeholder' => 'Ej: Juan Enrique...',
                'class' => '',
                'required' => false,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdNombre);
                            
            // Columna Cuenta
            const tdCuenta = document.createElement('td');
            tdCuenta.innerHTML = `<?= $this->Form->control('records.INDEX.CUENTA', [
                'label' => false,
                'placeholder' => 'Ej: 05987...',
                'class' => '',
                'type' => 'number',
                'required' => false,
                'minlength' => 16,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdCuenta);
                            
            // Columna Importe
            const tdImporte = document.createElement('td');
            tdImporte.innerHTML = `<?= $this->Form->control('records.INDEX.IMPORTE.', [
                'label' => false,
                'placeholder' => '0.00',
                'class' => '',
                'type' => 'number',
                'required' => false,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdImporte);
                            
            // Añadir la fila al tbody
            tbody.appendChild(tr);
                            
            // Actualizar números de fila (por si acaso, aunque ya pusimos el número correcto, pero al añadir múltiples se mantiene)
            updateRowNumbers();
        }

        // Evento click del botón
        addRowBtn.addEventListener('click', addRow);
    });
</script>
<?php $this->end(); ?>
