<?php

namespace App\Models;

class User {
    private $id;
    private $email;
    private $password;
    private $properties;

    public function __construct($id, $email, $password = null, $properties = []) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->properties = $properties;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'properties' => array_map(function($property) {
                return $property->toArray();
            }, $this->properties)
        ];
    }
}
