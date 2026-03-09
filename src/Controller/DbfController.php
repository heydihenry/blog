<?php
namespace App\Controller;

use App\Utility\DbfGenerator;

class DbfController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Requiere autenticación para acceder a DBF
        //$this->Authentication->addUnauthenticatedActions([]);
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
                ['name' => 'ID', 'type' => 'N', 'length' => 10, 'decimals' => 0],
                ['name' => 'NAME', 'type' => 'C', 'length' => 50, 'decimals' => 0],
                ['name' => 'EMAIL', 'type' => 'C', 'length' => 100, 'decimals' => 0],
                ['name' => 'CREATED', 'type' => 'D', 'length' => 8, 'decimals' => 0],
            ];

            $records = [];
            
            // Procesar datos del formulario
            if (isset($data['records']) && is_array($data['records'])) {
                $recordId = 1;
                foreach ($data['records'] as $idx => $record) {
                    if (!empty($record['NAME'])) { // Solo agregar si tiene nombre
                        $createdDate = $record['CREATED'] ?? date('Y-m-d');
                        // Convertir formato de fecha si es necesario
                        if (strpos($createdDate, '-') !== false) {
                            $createdDate = str_replace('-', '', $createdDate);
                        }
                        
                        $records[] = [
                            'ID' => $recordId,
                            'NAME' => substr($record['NAME'], 0, 50),
                            'EMAIL' => substr($record['EMAIL'] ?? '', 0, 100),
                            'CREATED' => $createdDate,
                        ];
                        $recordId++;
                    }
                }
            }

            if (empty($records)) {
                $this->Flash->error(__('Debes ingresar al menos un registro con nombre.'));
                return $this->redirect(['action' => 'generate']);
            }

            // Generar archivo DBF
            $generator = new DbfGenerator();
            $dbf = $generator->createDbf($fields, $records);

            $filename = 'datos_' . date('Ymd_His') . '.dbf';

            $this->response = $this->response
                ->withType('application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withHeader('Content-Length', (string)strlen($dbf))
                ->withStringBody($dbf);

            return $this->response;
        }

        // GET - mostrar formulario
        // Obtener número de registros a mostrar (por defecto 5, máximo 50)
        $recordCount = (int)($this->request->getQuery('rows', 5));
        $recordCount = min(max($recordCount, 1), 50);
        
        $this->set(compact('recordCount'));
    }
}
