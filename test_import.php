<?php
$data = "kode_duk,password,nama,kelas_ditugaskan\r\n20040301,password123,\"Ikan Asin\",\"X - RPL 1\"\r\n20040201,password123,\"Ikan Ayam\",\"X - RPL 2\"\r\n";
file_put_contents('test.csv', $data);

$handle = fopen('test.csv', 'r');
$header = fgetcsv($handle, 1000, ',');
if ($header && count($header) == 1 && strpos($header[0], ';') !== false) {
    rewind($handle);
    $header = fgetcsv($handle, 1000, ';');
    $delimiter = ';';
} else {
    $delimiter = ',';
}

if ($header) {
    $header = array_map(function($h) {
        return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h));
    }, $header);
}

$map = array_flip($header);
if (!isset($map['kode_duk']) || !isset($map['nama'])) {
    echo "Header error\n";
    exit;
}

$importedCount = 0;
while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
    if (empty($row) || count($row) < 2) {
        echo "Skipping row: " . json_encode($row) . "\n";
        continue;
    }
    
    $kodeDuk = trim($row[$map['kode_duk']] ?? '');
    $nama = trim($row[$map['nama']] ?? '');
    
    if (empty($kodeDuk) || empty($nama)) {
        echo "Empty duk or nama: $kodeDuk, $nama\n";
        continue;
    }
    
    $importedCount++;
}
echo "Imported: $importedCount\n";
