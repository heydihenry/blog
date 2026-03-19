<?php
namespace App\Controller;

use App\Utility\DbfGenerator;

class DbfController extends AppController
{
    /*public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Requiere autenticación para acceder a DBF
        $this->Authentication->addUnauthenticatedActions([]);
    }*/

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * Vista principal con las dos pestañas.
     */
    public function index()
    {
        // Solo renderiza la vista
    }
    //Convertir los caracteres de vocales tildadas en vocales simples
    private function eliminarAcentos($texto) 
    {
        $acentos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ñ' => 'n', 'Ñ' => 'N',
            'ü' => 'u', 'Ü' => 'U',
            'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
        ];
        
        return strtr($texto, $acentos);
    }

    /**
     * Genera archivo DBF con datos ingresados por el usuario
     */
    public function generate()
    {
        if ($this->request->is('post')) {
            // Procesar POST - generar archivo DBF
            $data = $this->request->getData();

            // Definir estructura fija de campos
            $fields = [
                ['name' => 'COD_TIPID', 'type' => 'C', 'length' => 2],
                ['name' => 'COD_PAEXID', 'type' => 'N', 'length' => 3],
                ['name' => 'NUM_IDEPER', 'type' => 'N', 'length' => 11],
                ['name' => 'CTA_MNAC', 'type' => 'N', 'length' => 16],
                ['name' => 'IMPORTE_N', 'type' => 'N', 'length' => 16, 'decimals' => 2],
                ['name' => 'CTA_MLC', 'type' => 'C', 'length' => 16],
                ['name' => 'IMPORTE_D', 'type' => 'N', 'length' => 16, 'decimals' => 2]
            ];

            $records = [];
            
            // Procesar datos del formulario
            if (isset($data['records']) && is_array($data['records'])) {
                $recordId = 1;
                foreach ($data['records'] as $idx => $record) {
                    if (!empty($record['NOMBRE'])) { // Solo agregar si tiene nombre
                        
                        $records[] = [ //Colocando los valores por defecto y haciendo ajustes 
                            'COD_TIPID' => 'CI',
                            'COD_PAEXID' => 247,
                            'NUM_IDEPER' => isset($record['CARNET']) ? substr($record['CARNET'], 0, 11) : '',
                            'CTA_MNAC' => isset($record['CUENTA']) ? substr($record['CUENTA'], 0, 16) : '',
                            'IMPORTE_N' => isset($record['IMPORTE']) ? number_format((float)$record['IMPORTE'], 2, '.', '') : '0.00',
                            'CTA_MLC' => substr($this->eliminarAcentos($record['NOMBRE']), 0, 40), // ya sabemos que existe por !empty
                            'IMPORTE_D' => 0
                        ];
                        $recordId++;
                    }
                }
            }

            // Comprobando si realmente el usuario introdujo datos (Principalmente el nombre)
            if (empty($records)) { 
                $this->Flash->error(__('Debes ingresar al menos un registro con nombre.'));
                return $this->redirect(['action' => 'generate']);
            }

            // Generar archivo DBF
            $generator = new DbfGenerator();
            $dbf = $generator->createDbf($fields, $records);

            //Creando el nombre del archivo
            $filename = 'nomina_' . date('Ymd_His') . '.dbf';

            $this->response = $this->response
                ->withType('application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withHeader('Content-Length', (string)strlen($dbf))
                ->withStringBody($dbf);

            return $this->response;
        }
    }
    /*  
    Control para editar los datos de las bases de datos
    */
    public function edit() {
        //Comprobando si la peticion es POST
        if($this->request->is('POST')) {
            $uploadFile = $this->request->getData('dbf_file');

            if (!$uploadFile ||  $uploadFile->getError() !== UPLOAD_ERR_OK) {
                $this->Flash->error('No se pudo abrir el archivo .DBF.');
                return [];
            }

            $filePath = $uploadFile->getStream()->getMetadata('uri');

            $data = $this->processDbf($filePath);

            if (empty($data)) {
                $this->Flash->error('El archivo .dbf no contiene datos válidos o no pudo ser procesado.');
                return;
            }

            // Enviar los datos a la vista
            $this->set('dbfData', $data);
            $this->set('fileName', $uploadFile->getClientFilename());
        }
    }
    private function processDbf(string $filePath): array {
        $fdbf = fopen($filePath, 'rb');
        if (!$fdbf) return [];
        
        // Leer cabecera (primeros 32 bytes)
        $header = fread($fdbf, 32);
        $recordCount = unpack('V', substr($header, 4, 4))[1];
        $recordLength = unpack('v', substr($header, 10, 2))[1];
        
        // Saltar la sección de campos hasta el terminador 0x0D
        while (!feof($fdbf) && fread($fdbf, 1) != chr(0x0D));
        
        // Posicionarse al inicio de los registros
        fseek($fdbf, ftell($fdbf) + 1);
        
        $records = [];
        for ($i = 0; $i < $recordCount; $i++) {
            $recordData = fread($fdbf, $recordLength);
            // Aquí necesitarías parsear cada campo según su tipo...
            $records[] = ['raw' => bin2hex($recordData)]; // Simplificación
        }
        
        fclose($fdbf);
        return $records;
    }
}
