<?php 

namespace App\Storage;

use App\Storage\Contracts\StorageInterface;


class SessionStorage implements StorageInterface
{

    public function set($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $_SESSION[$this->key] = $this->value;
        return $_SESSION[$this->key];
    }

    public function get($key)
    {
        if(isset($_SESSION[$key])) {
            $this->key = $_SESSION[$key];
            return $this->key;
        }
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
        return;
    }

    public function destroy()
    {
        unset($_SESSION);
    }

    public function all()
    {
        if(isset($_SESSION)) {
            return $_SESSION;
        }
    }
}