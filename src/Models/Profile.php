<?php

namespace App\Models;

class Profile {
    private $id;
    private $name;
    private $model;
    private $properties;
    
    public function __construct($id, $name, $model = 'default', $properties = []) {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->properties = $properties;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getModel() {
        return $this->model;
    }
    
    public function getProperties() {
        return $this->properties;
    }
    
    public function toArray($options = []) {
        $data = [
            'id' => $this->id,
            'name' => $this->name
        ];
        
        if (!isset($options['properties']) || $options['properties'] !== false) {
            $data['properties'] = array_map(function($prop) {
                return $prop->toArray();
            }, $this->properties);
        }
        
        return $data;
    }
}
