<?php
namespace App\Utility;

class DbfGenerator
{
    /**
     * Crea el contenido binario de un archivo DBF simple (dBase III)
     * @param array $fields Array de campos con keys: name, type, length, decimals
     * @param array $records Array de registros asociativos
     * @return string Contenido binario del DBF
     */
    public function createDbf(array $fields, array $records): string
    {
        $now = getdate();
        $header = '';
        $header .= chr(0x03); // dBase III
        $header .= chr($now['year'] - 1900);
        $header .= chr($now['mon']);
        $header .= chr($now['mday']);

        $recordCount = count($records);
        // record count (4 bytes, little-endian)
        $header .= pack('V', $recordCount);

        $fieldCount = count($fields);
        $headerLength = 32 + ($fieldCount * 32) + 1; // header + field descriptors + terminator
        $recordLength = 1; // deletion flag
        foreach ($fields as $f) {
            $recordLength += (int)$f['length'];
        }

        $header .= pack('v', $headerLength);
        $header .= pack('v', $recordLength);
        $header .= str_repeat("\x00", 20); // reserved

        // Field descriptors
        $fieldDescriptors = '';
        foreach ($fields as $f) {
            $name = strtoupper($f['name']);
            $name = substr($name, 0, 11);
            $name = str_pad($name, 11, "\x00");
            $type = $f['type'];
            $fieldDescriptors .= $name;
            $fieldDescriptors .= $type;
            $fieldDescriptors .= pack('V', 0); // field data address (not used)
            $fieldDescriptors .= chr((int)$f['length']);
            $fieldDescriptors .= chr((int)($f['decimals'] ?? 0));
            $fieldDescriptors .= str_repeat("\x00", 14);
        }

        $header .= $fieldDescriptors;
        $header .= chr(0x0D); // header terminator

        // Records
        $body = '';
        foreach ($records as $rec) {
            $body .= ' '; // deletion flag (space = active)
            foreach ($fields as $f) {
                $len = (int)$f['length'];
                $name = $f['name'];
                $type = $f['type'];
                $value = isset($rec[$name]) ? $rec[$name] : '';
                if ($type === 'C') {
                    $s = substr((string)$value, 0, $len);
                    $s = str_pad($s, $len, ' ');
                } elseif ($type === 'N') {
                    $s = is_numeric($value) ? (string)$value : '0';
                    $s = str_pad($s, $len, ' ', STR_PAD_LEFT);
                } elseif ($type === 'D') {
                    if ($value instanceof \DateTimeInterface) {
                        $s = $value->format('Ymd');
                    } else {
                        $s = substr((string)$value, 0, 8);
                        $s = str_pad($s, 8, '0', STR_PAD_LEFT);
                    }
                    $s = str_pad($s, $len, ' ');
                } else {
                    $s = str_pad(substr((string)$value, 0, $len), $len, ' ');
                }
                $body .= $s;
            }
        }

        $dbf = $header . $body . chr(0x1A);
        return $dbf;
    }
}
