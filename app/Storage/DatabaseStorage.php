<?php 

namespace App\Storage;

use App\Storage\Contracts\StorageInterface;



class DatabaseStorage implements StorageInterface
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function set($key, $value)
    {
        $this->key = $key;
        $this->value = $value;

        $statement = $this->db->prepare("INSERT INTO storage (id, value) VALUES (:id, :value)");
        $statement->execute([
            'id' => $this->key,
            'value' => $this->value,
        ]);
        return $this->db->lastInsertId();
    }

    public function get($key)
    {
        $statement = $this->db->prepare('SELECT * FROM storage WHERE id = :id');
        $statement->execute(['id' => $key]);
        $result = $statement->fetch();
        if(!empty($result)){
            return $result['value'];
        }
    }

    public function delete($key)
    {
        $statement = $this->db->prepare('DELETE FROM storage WHERE id = :id');
        $statement->execute(['id' => $key]);
        $statement->execute();
    }

    public function destroy()
    {
        $statement = $this->db->prepare('DELETE FROM storage');
        $statement->execute();
    }

    public function all()
    {
        $statement = $this->db->prepare('SELECT * FROM storage');
        $statement->execute();
        $result = $statement->fetchAll();
        if(count($result) <= 0){
            return;
        }
        return $result;
    }
}