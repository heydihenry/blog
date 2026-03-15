<?php
namespace App\Controller;

use App\Utility\DbfGenerator;

class DbfController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Requiere autenticación para acceder a DBF
        $this->Authentication->addUnauthenticatedActions([]);
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
                ['name' => 'COD_TIPID', 'type' => 'C', 'length' => 2, 'decimals' => 0],
                ['name' => 'COD_PAEXID', 'type' => 'N', 'length' => 3, 'decimals' => 0],
                ['name' => 'NUM_IDEPER', 'type' => 'N', 'length' => 13, 'decimals' => 0],
                ['name' => 'CTA_MNAC', 'type' => 'N', 'length' => 16, 'decimals' => 0],
                ['name' => 'IMPORTE_N', 'type' => 'N', 'length' => 8, 'decimals' => 2],
                ['name' => 'CTA_MLC', 'type' => 'C', 'length' => 50, 'decimals' => 0],
                ['name' => 'IMPORTE_D', 'type' => 'N', 'length' => 8, 'decimals' => 2]
            ];

            $records = [];
            
            // Procesar datos del formulario
            if (isset($data['records']) && is_array($data['records'])) {
                $recordId = 1;
                foreach ($data['records'] as $idx => $record) {
                    $this->Flash->info('Intenté');
                    $this->Flash->info(json_encode($record));
                    $this->Flash->info(json_encode(!empty($record['NOMBRE'])));
                    if (!empty($record['NOMBRE'])) { // Solo agregar si tiene nombre
                        
                        $records[] = [ //Colocando los valores por defecto y haciendo ajustes 
                            'COD_TIPID' => 'CI',
                            'COD_PAEXID' => 247,
                            'NUM_IDEPER' => isset($record['CARNET']) ? substr($record['CARNET'], 0, 11) : '',
                            'CTA_MNAC' => isset($record['CUENTA']) ? substr($record['CUENTA'], 0, 16) : '',
                            'IMPORTE_N' => isset($record['IMPORTE']) ? number_format((float)$record['IMPORTE'], 2, '.', '') : '0.00',
                            'CTA_MLC' => substr($record['NOMBRE'], 0, 40), // ya sabemos que existe por !empty
                            'IMPORTE_D' => 0
                        ];
                        $recordId++;
                    }
                }
            }

            if (empty($records)) { // Comprobando si realmente el usuario introdujo datos (Principalmente el nombre)
                $this->Flash->error(__('Debes ingresar al menos un registro con nombre.'));
                return $this->redirect(['action' => 'generate']);
            }

            // Generar archivo DBF
            $generator = new DbfGenerator();
            $dbf = $generator->createDbf($fields, $records);

            $filename = 'nomina_' . date('Ymd_His') . '.dbf';

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
