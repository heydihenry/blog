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
                        'id' => 'customFileButton'
                    ]
                ) ?> 
                <input type="file" accept='.dbf' style="display: none" id="fileInput">
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
                            <th style="width: 20%;">Carnet</th>
                            <th style="width: 30%;">Nombre</th>
                            <th style="width: 27%;">Cuenta</th>
                            <th style="width: 18%;">Importe</th>
                            <th style="width: 5%;">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTable">
                        <tr class="record-row">
                            <td>
                                <?= $this->Form->control('records.' . 0 . '.CARNET', [
                                    'id' => 'records[0][CARNET]',
                                    'label' => false,
                                    'placeholder' => 'Ej: 000101...',
                                    'class' => 'CARNET',
                                    'required' => false,
                                    'type' => 'number',
                                    'minlength' => 11,
                                    'maxlenght' => 11,
                                    'style' => 'width: 100%'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . 0 . '.NOMBRE', [
                                    'id' => 'records[0][NOMBRE]',
                                    'label' => false,
                                    'placeholder' => 'Ej: Juan Enrique...',
                                    'class' => 'NOMBRE',
                                    'required' => false,
                                    'type' => 'text',
                                    'maxlength' => 16,
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . 0 . '.CUENTA', [
                                    'id' => 'records[0][CUENTA]',
                                    'label' => false,
                                    'placeholder' => 'Ej: 05987...',
                                    'class' => 'CUENTA',
                                    'type' => 'number',
                                    'required' => false,
                                    'minlength' => 16,
                                    'maxlength' => 16,
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                            <td>
                                <?= $this->Form->control('records.' . 0 . '.IMPORTE', [
                                    'id' => 'records[0][IMPORTE]',
                                    'label' => false,
                                    'step' => 0.01,
                                    'value' => 0.00,
                                    'placeholder' => '0.00',
                                    'class' => 'IMPORTE',
                                    'type' => 'text',
                                    'required' => false,
                                    'maxlength' => 16,
                                    'style' => 'width: 100%;'
                                ]) ?>
                            </td>
                            <td>
                                <button type="button"
                                    class="btn-eliminar"
                                    style="border: 1px solid #000; border-radius: 5px; text-align: center; width: 100%;"
                                    onclick="this.closest('tr').remove(); actualizarTotal();">
                                    -
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style="border-top: 1px solid #000; padding: 5px;">
                        <tr>
                            <td style="text-align: right;"
                                colspan="3"> Total:
                            </td>
                            <td id="totalImporte">0.00</td>
                        </tr>
                    </tfoot>
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
                        'id' => 'downloadBtn'
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


<?php $this->append('script'); ?>
<script>  
    //Script para añadir filas dinámicamente
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
                            
            // Columna Carnet
            const tdCarnet = document.createElement('td');
            tdCarnet.innerHTML = `<?= $this->Form->control('records.INDEX.CARNET', [
                'id' => 'records[INDEX][CARNET]',
                'label' => false,
                'placeholder' => 'Ej:000101...',
                'class' => 'CARNET',
                'required' => false,
                'type' => 'number',
                'minlength' => 11,
                'maxlength' => 11,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdCarnet);
                            
            // Columna Nombre
            const tdNombre = document.createElement('td');
            tdNombre.innerHTML = `<?= $this->Form->control('records.INDEX.NOMBRE', [
                'id' => 'records[INDEX][NOMBRE]',
                'label' => false,
                'placeholder' => 'Ej: Juan Enrique...',
                'class' => 'NOMBRE',
                'required' => false,
                'minlength' => 16,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdNombre);
                            
            // Columna Cuenta
            const tdCuenta = document.createElement('td');
            tdCuenta.innerHTML = `<?= $this->Form->control('records.INDEX.CUENTA', [
                'id' => 'records[INDEX][CUENTA]',
                'label' => false,
                'placeholder' => 'Ej: 05987...',
                'class' => 'CUENTA',
                'type' => 'number',
                'required' => false,
                'minlength' => 16,
                'maxlength' => 16,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdCuenta);
                            
            // Columna Importe
            const tdImporte = document.createElement('td');
            tdImporte.innerHTML = `<?= $this->Form->control('records.INDEX.IMPORTE', [
                'id' => 'records[INDEX][IMPORTE]',
                'label' => false,
                'placeholder' => '0.00',
                'class' => 'IMPORTE',
                'type' => 'text',
                'required' => false,
                'maxlength' => 16,
                'style' => 'width: 100%;'
            ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
            tr.appendChild(tdImporte);

            // Celda con botón eliminar
            const tdAccion = document.createElement('td');
            const btnEliminar = document.createElement('button');
            btnEliminar.type = 'button';
            btnEliminar.textContent = ' - ';
            btnEliminar.className = 'btn-eliminar'; // para identificar
            btnEliminar.style = 'border: 1px solid #000; border-radius: 5px; text-align: center; width: 100%'
            btnEliminar.onclick = function() {
                tr.remove(); // Elimina la fila del DOM
            };
            tdAccion.appendChild(btnEliminar);
            tr.appendChild(tdAccion);
                            
            // Añadir la fila al tbody
            tbody.appendChild(tr);
                            
            // Actualizar números de fila (por si acaso, aunque ya pusimos el número correcto, pero al añadir múltiples se mantiene)
            updateRowNumbers();
        }

        // Evento click del botón
        addRowBtn.addEventListener('click', addRow);
    });

    //Script para cargar un archivo formato .dbf
    // Obtener referencias a los elementos
    const customFileButton = document.getElementById('customFileButton');
    const fileInput = document.getElementById('fileInput');

    // Al hacer clic en el botón personalizado, se dispara el input file
    customFileButton.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {

        //El archivo que se introdujo
        const archive = fileInput.files[0]

        if(!archive) {
            alert(`Archivo erroneo`)
            throw new Error('Archivo erroneo')
        }

        const reader = new FileReader()
        reader.onload = (event) => {
            const dataDBF = parseDBF(event.target.result)
            //Eliminando todas las filas existentes exepto la primera antes de comenzar a cargar los datos del archivo
            document.querySelector('tbody[id="recordsTable"]').querySelectorAll('tr.record-row').forEach((row, index) => {
                if (index > 0) {
                    row.remove();
                }
            });
            for (let i = 0; i < dataDBF.numRecords; i++) {
                //Funcionalidad para añadir fila nueva
                const tbody = document.querySelector('tbody[id="recordsTable"]');
                if (!tbody) return;
                // Contar las filas existentes con la clase 'record-row'
                const filasExistentes = tbody.querySelectorAll('tr.record-row').length;
                // Suponiendo que 'i' es el índice del registro actual (0, 1, 2...)
                // Si el índice actual es mayor o igual al número de filas, significa que falta esta fila
                if (i >= filasExistentes-1 && i != 0) {
                    // El nuevo índice puede ser 'i' para mantener correspondencia
                    const newIndex = i;
                    // Crear la fila
                    const tr = document.createElement('tr');
                    tr.className = 'record-row';
                    tr.style.marginTop = '5px';
                    // Columna Carnet
                    const tdCarnet = document.createElement('td');
                    tdCarnet.innerHTML = `<?= $this->Form->control('records.INDEX.CARNET', [
                        'id' => 'records[INDEX][CARNET]',
                        'label' => false,
                        'placeholder' => 'Ej:000101...',
                        'class' => 'CARNET',
                        'required' => false,
                        'type' => 'number',
                        'minlength' => 11,
                        'maxlength' => 11,
                        'style' => 'width: 100%;'
                    ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
                    tr.appendChild(tdCarnet);

                    // Columna Nombre
                    const tdNombre = document.createElement('td');
                    tdNombre.innerHTML = `<?= $this->Form->control('records.INDEX.NOMBRE', [
                        'id' => 'records[INDEX][NOMBRE]',
                        'label' => false,
                        'placeholder' => 'Ej: Juan Enrique...',
                        'class' => 'NOMBRE',
                        'required' => false,
                        'minlength' => 16,
                        'style' => 'width: 100%;'
                    ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
                    tr.appendChild(tdNombre);

                    // Columna Cuenta
                    const tdCuenta = document.createElement('td');
                    tdCuenta.innerHTML = `<?= $this->Form->control('records.INDEX.CUENTA', [
                        'id' => 'records[INDEX][CUENTA]',
                        'label' => false,
                        'placeholder' => 'Ej: 05987...',
                        'class' => 'CUENTA',
                        'type' => 'number',
                        'required' => false,
                        'minlength' => 16,
                        'maxlength' => 16,
                        'style' => 'width: 100%;'
                    ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
                    tr.appendChild(tdCuenta);

                    // Columna Importe (corregido: sin punto final en el nombre)
                    const tdImporte = document.createElement('td');
                    tdImporte.innerHTML = `<?= $this->Form->control('records.INDEX.IMPORTE', [
                        'id' => 'records[INDEX][IMPORTE]',
                        'label' => false,
                        'placeholder' => '0.00',
                        'class' => 'IMPORTE',
                        'type' => 'text',
                        'required' => false,
                        'style' => 'width: 100%;'
                    ]) ?>`.replace(/records\[INDEX\]/g, `records[${newIndex}]`);
                    tr.appendChild(tdImporte);

                    // Celda con botón eliminar
                    const tdAccion = document.createElement('td');
                    const btnEliminar = document.createElement('button');
                    btnEliminar.type = 'button';
                    btnEliminar.textContent = ' - ';
                    btnEliminar.className = 'btn-eliminar';
                    btnEliminar.style.cssText = 'border: 1px solid #000; border-radius: 5px; text-align: center; width: 100%;';
                    btnEliminar.onclick = function() {
                        tr.remove(); // Elimina la fila del DOM
                        actualizarTotal()
                    };
                    tdAccion.appendChild(btnEliminar);
                    tr.appendChild(tdAccion);

                    // Añadir la fila al tbody
                    tbody.appendChild(tr);
                }
                
                document.querySelector(`input[name="records[${i}][CARNET]"]`).value = dataDBF.records[i]['NUM_IDEPER'];
                document.querySelector(`input[name="records[${i}][NOMBRE]"]`).value = dataDBF.records[i]['CTA_MLC'];
                document.querySelector(`input[name="records[${i}][CUENTA]"]`).value = dataDBF.records[i]['CTA_MNAC'];
                document.querySelector(`input[name="records[${i}][IMPORTE]"]`).value = dataDBF.records[i]['IMPORTE_N'];
            }
            actualizarTotal()
        }

        reader.readAsArrayBuffer(archive)
    });

    function parseDBF(arrayBuffer) {
        const view = new DataView(arrayBuffer);
        let offset = 0;
        // --- Cabecera principal (32 bytes) ---
        const version = view.getUint8(offset); offset += 1;
        const year = view.getUint8(offset) + 1900; offset += 1;
        const month = view.getUint8(offset); offset += 1;
        const day = view.getUint8(offset); offset += 1;
        const numRecords = view.getUint32(offset, true); offset += 4;
        const headerLen = view.getUint16(offset, true); offset += 2;
        const recordLen = view.getUint16(offset, true); offset += 2;
        offset = 32; // Saltar bytes reservados
        
        // --- Descriptores de campo ---
        const fields = [];
        while (offset < headerLen - 1) {
            // Nombre (11 bytes, null-terminated)
            let name = '';
            for (let i = 0; i < 11; i++) {
                const byte = view.getUint8(offset + i);
                if (byte === 0) break;
                name += String.fromCharCode(byte);
            }
            offset += 11;

            const type = String.fromCharCode(view.getUint8(offset)); offset += 1;
            offset += 4; // Saltar dirección (4 bytes)
            const length = view.getUint8(offset); offset += 1;
            const decimals = view.getUint8(offset); offset += 1;
            offset += 14; // Saltar reservados

            fields.push({ name, type, length, decimals });

            if (view.getUint8(offset) === 0x0D) { // Terminador
                offset += 1;
                break;
            }
        }
        offset = headerLen; // Inicio de registros
        
        // --- Registros ---
        const records = [];
        for (let i = 0; i < numRecords; i++) {
        const deletedFlag = view.getUint8(offset);
        const record = { _deleted: deletedFlag === 0x2A };
        let dataOffset = offset + 1;

        fields.forEach(field => {
            let raw = '';
            for (let j = 0; j < field.length; j++) {
                raw += String.fromCharCode(view.getUint8(dataOffset + j));
            }
            dataOffset += field.length;

            let value;
            if (field.type === 'N' || field.type === 'F') {
                const trimmed = raw.trim();
                value = trimmed === '' ? null : parseFloat(trimmed);
            } else if (field.type === 'L') {
                const ch = raw.trim().toUpperCase();
                if (ch === 'T' || ch === 'Y') value = true;
                else if (ch === 'F' || ch === 'N') value = false;
                else value = null;
            } else if (field.type === 'D') {
                const trimmed = raw.trim();
                if (trimmed.length === 8 && !isNaN(trimmed)) {
                    value = `${trimmed.slice(0,4)}-${trimmed.slice(4,6)}-${trimmed.slice(6,8)}`;
                } else value = null;
            } else {
              value = raw.replace(/\s+$/, ''); // Quitar espacios finales
            }
            record[field.name] = value;
        });
        
        records.push(record);
        offset += recordLen;
        }

        return {
            version,
            lastUpdate: { year, month, day },
            numRecords,
            headerLen,
            recordLen,
            fields,
            records
        };
    }

    // Función para calcular la suma de todos los importes
    const tabla = document.getElementById('recordsTable');
    const tbody = tabla.querySelector('tbody');
    const totalSpan = document.getElementById('totalImporte');

    // Función para calcular la suma de todos los importes
    function actualizarTotal() {
        let total = 0;
        // Seleccionar todos los inputs con clase 'IMPORTE' dentro de la tabla
        const inputsImporte = tabla.querySelectorAll('input.IMPORTE');
        if(inputsImporte.values) {
            inputsImporte.forEach(input => {
                // Obtener el valor como número, si es válido
                const valor = parseFloat(input.value);
                if (!isNaN(valor)) {
                    total += valor;
                }
            });
        }
        // Actualizar el total en la celda
        totalSpan.textContent = total.toFixed(2);
    }

    // Delegación de eventos: escucha en la tabla cualquier cambio de input
    tabla.addEventListener('input', function(e) {
        // Si el elemento que cambió es un input con clase 'IMPORTE'
        const input = e.target.closest('input.IMPORTE');
        const elimn = e.target.closest('buttom.btn-eliminar')
        if (input || elimn) {
            actualizarTotal();
        }
    });

    //Deteccion de extension del input
    const carnet = tabla.querySelectorAll(`input[class="CARNET"]`);
    const cuenta = tabla.querySelectorAll(`input[class="CUENTA"]`);
    const importe = tabla.querySelectorAll('input[class="IMPORTE"]');

    tabla.addEventListener('input', function(e) {
        if(e.target.classList.contains('CARNET')) {
            e.target.value = e.target.value.replace(/[^\d]/g, '');
            if(e.target.value.length > 11) {
                e.target.value = e.target.value.slice(0, 11);
            }
        }
        else if(e.target.classList.contains('CUENTA')) {
            e.target.value = e.target.value.replace(/[^\d]/g, '');
            if(e.target.value.length > 16) {
                e.target.value = e.target.value.slice(0, 16);
            }
        }
        else if(e.target.classList.contains('IMPORTE')) {
            e.target.value = e.target.value.replace(/[^\d.]/g, '');
            if(e.target.value.split('.')[1]?.length > 2) {
                e.target.value = `${e.target.value.split('.')[0]}.${e.target.value.split('.')[1].slice(0, 2)}`
            }
        }
    });

    //Añadir comprobacion de los datos antes de enviar el formulario
    const form = document.getElementById('dbfForm');
    form.addEventListener('submit', function(e) {
        const inputsCarnet = form.querySelectorAll('input.CARNET');
        const inputsCuenta = form.querySelectorAll('input.CUENTA');
        const inputsImporte = form.querySelectorAll('input.IMPORTE');
        const inputsNombre = form.querySelectorAll('input.NOMBRE');
    
        // Validar CARNET (requerido y 11 dígitos)
        for (let i = 0; i < inputsCarnet.length; i++) {
            const valor = inputsCarnet[i].value.trim();
            if (valor === '') {
                alert(`El carnet en la fila ${i + 1} es obligatorio.`);
                e.preventDefault();
                return;
            }
            if (valor.length !== 11) {
                alert(`El carnet en la fila ${i + 1} debe tener exactamente 11 dígitos.`);
                e.preventDefault();
                return;
            }
        }
    
        // Validar CUENTA (requerido y 16 dígitos)
        for (let i = 0; i < inputsCuenta.length; i++) {
            const valor = inputsCuenta[i].value.trim();
            if (valor === '') {
                alert(`La cuenta en la fila ${i + 1} es obligatoria.`);
                e.preventDefault();
                return;
            }
            if (valor.length !== 16) {
                alert(`La cuenta en la fila ${i + 1} debe tener exactamente 16 dígitos.`);
                e.preventDefault();
                return;
            }
        }
    
        // Validar IMPORTE (requerido y número válido)
        for (let i = 0; i < inputsImporte.length; i++) {
            const valor = inputsImporte[i].value.trim();
            if (valor === '') {
                alert(`El importe en la fila ${i + 1} es obligatorio.`);
                e.preventDefault();
                return;
            }
            if (isNaN(parseFloat(valor))) {
                alert(`El importe en la fila ${i + 1} debe ser un número válido.`);
                e.preventDefault();
                return;
            }
        }
    
        // Validar NOMBRE (requerido, no solo espacios)
        for (let i = 0; i < inputsNombre.length; i++) {
            const valor = inputsNombre[i].value.trim();
            if (valor === '') {
                alert(`El nombre en la fila ${i + 1} es obligatorio.`);
                e.preventDefault();
                return;
            }
            // Opcional: validar longitud mínima o formato, si lo necesitas
        }
    });
</script>
<?php $this->end(); ?>
