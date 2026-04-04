<?php

namespace App\Models;

class Property {
    private $name;
    private $value;
    private $signature;

    public function __construct($name, $value, $signature = null) {
        $this->name = $name;
        $this->value = $value;
        $this->signature = $signature;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getSignature() {
        return $this->signature;
    }

    public function toArray() {
        $array = [
            'name' => $this->name,
            'value' => $this->value
        ];
        if ($this->signature) {
            $array['signature'] = $this->signature;
        }
        return $array;
    }
}
