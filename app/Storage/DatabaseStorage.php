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
        $statement = $this->db->prepare('SELECT * FROM storage WHERE id = :id');
        $statement->execute(['id' => $key]);
        $result = $statement->fetch();
        if(!empty($result)){
            $statement = $this->db->prepare("UPDATE storage SET id = :id, value = :value WHERE id = :id");
            $values = [
                'id' => $this->key,
                'value' => serialize($this->value),
            ];
            $statement->execute($values);
            return $this->db->lastInsertId();
        }
        else{
            $statement = $this->db->prepare("INSERT INTO storage (id, value) VALUES (:id, :value)");
            $statement->execute([
                'id' => $this->key,
                'value' => serialize($this->value),
            ]);
        }
        
        return $this->db->lastInsertId();
    }

    public function get($key)
    {
        $statement = $this->db->prepare('SELECT * FROM storage WHERE id = :id');
        $statement->execute(['id' => $key]);
        $result = $statement->fetch();
        if(!empty($result)){
            return unserialize($result['value']);
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
        $items = [];
        if(count($result) <= 0){
            return;
        }
        foreach($result as $value){
            $items[] = unserialize($value['value']);
        }
        return $items;
    }
}