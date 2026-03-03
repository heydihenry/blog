<?php
namespace App\Controller;

use App\Utility\DbfGenerator;

class DbfController extends AppController
{
    public function generate()
    {
        $fields = [
            ['name' => 'ID', 'type' => 'N', 'length' => 10, 'decimals' => 0],
            ['name' => 'NAME', 'type' => 'C', 'length' => 50, 'decimals' => 0],
            ['name' => 'CREATED', 'type' => 'D', 'length' => 8, 'decimals' => 0],
        ];

        $records = [
            ['ID' => 1, 'NAME' => 'Primer artículo', 'CREATED' => date('Ymd')],
            ['ID' => 2, 'NAME' => 'Segundo artículo', 'CREATED' => date('Ymd')],
            ['ID' => 3, 'NAME' => 'Tercero', 'CREATED' => date('Ymd')],
        ];

        $generator = new DbfGenerator();
        $dbf = $generator->createDbf($fields, $records);

        $filename = 'test_' . date('Ymd_His') . '.dbf';

        $this->response = $this->response
            ->withType('application/octet-stream')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withHeader('Content-Length', (string)strlen($dbf))
            ->withStringBody($dbf);

        return $this->response;
    }
}
