<?php

require 'fonctions.php';

$rows = assemblage_cache_nutriment_ref();

$data = [];
foreach ($rows as $row) {
    $data[$row['const_code']] = $row;
}

file_put_contents(
    __DIR__ . '/cache/nutriment_ref.php',
    '<?php return ' . var_export($data, true) . ';'
);