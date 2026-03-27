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

            if(!$data) {
                $this->Flash->error(__('Debes ingresar al menos un registro.'));
                return $this->redirect(['action' => 'generate']);
            }

            // Definir estructura fija de campos
            $fields = [
                ['name' => 'COD_TIPID', 'type' => 'C', 'length' => 2],
                ['name' => 'COD_PAEXID', 'type' => 'N', 'length' => 3],
                ['name' => 'NUM_IDEPER', 'type' => 'C', 'length' => 11],
                ['name' => 'CTA_MNAC', 'type' => 'C', 'length' => 16],
                ['name' => 'IMPORTE_N', 'type' => 'N', 'length' => 16, 'decimals' => 2],
                ['name' => 'CTA_MLC', 'type' => 'C', 'length' => 16],
                ['name' => 'IMPORTE_D', 'type' => 'N', 'length' => 16, 'decimals' => 2]
            ];

            $records = [];
            
            // Procesar datos del formulario
            if (isset($data['records']) && is_array($data['records'])) {
                $recordId = 1;
                foreach ($data['records'] as $idx => $record) {
                    // Solo agregar si cumple con los requisitos
                    if (!empty($record['NOMBRE'])) { 
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
}
