<?php 

namespace App\Storage;

use App\Storage\Contracts\StorageInterface;


class FileStorage implements StorageInterface
{

    public function set($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $filepath = __DIR__ . '/../../storage/items/';
        $file = fopen($filepath . $this->key, 'c+b');
        fwrite($file, $this->value);
    }

    public function get($key)
    {
        $this->key = $key;
        $filepath = __DIR__ . '/../../storage/items/';

        if(file_exists($filepath . $this->key)) {
            $file = fopen(__DIR__ . '/../../storage/items/' . $this->key, 'r+');
            $fileContent = fgets($file);
            fclose($file);

            return $fileContent;
        }
    }

    public function delete($key)
    {
        $this->key = $key;
        $filepath = __DIR__ . '/../../storage/items/';
        unlink ($filepath . $this->key);
    }

    public function destroy()
    {
        $filepath = __DIR__ . '/../../storage/items/';
        array_map('unlink', glob($filepath . '*'));
    }

    public function all()
    {
        $filepath = __DIR__ . '/../../storage/items/';
        $fileArray = array_diff(scandir($filepath), array('..', '.'));
        if(count($fileArray) <= 0){
            return;
        }
        $files = array();
        foreach($fileArray as $key => $file){
            $fileGet = fopen($filepath . $file, 'r+');
            $fileContent = fgets($fileGet);

            array_push($files, $fileContent);
            fclose($fileGet);
        }
        return $files;
    }
}