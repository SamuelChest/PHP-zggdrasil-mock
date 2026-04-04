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

    public function getName() {
        return $this->name;
    }

    public function getModel() {
        return $this->model;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function toArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name
        ];
        if ($this->model) {
            $array['model'] = $this->model;
        }
        if (!empty($this->properties)) {
            $array['properties'] = array_map(function($property) {
                return $property->toArray();
            }, $this->properties);
        }
        return $array;
    }
}
