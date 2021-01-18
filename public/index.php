<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=exercice", "root", "rootroot");
} catch (PDOException $e) {
    die($e->getMessage());
}

// SESSION //
//$store = new App\Storage\SessionStorage;

// FILES //
//$store = new App\Storage\FileStorage;

// DATABASE //
$store = new App\Storage\DatabaseStorage($pdo);


$store->set('name', 'Clement');
$store->set('age', 33);
$store->set('age', 43);
$store->delete('name');
$store->destroy();
echo $store->get('age');
print_r($store->all());