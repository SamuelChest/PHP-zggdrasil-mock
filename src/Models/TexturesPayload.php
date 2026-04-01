<?php

namespace App\Models;

class TexturesPayload {
    private $timestamp;
    private $profileId;
    private $profileName;
    private $textures;
    
    public function __construct($timestamp, $profileId, $profileName, $textures) {
        $this->timestamp = $timestamp;
        $this->profileId = $profileId;
        $this->profileName = $profileName;
        $this->textures = $textures;
    }
    
    public function toJson() {
        return json_encode([
            'timestamp' => $this->timestamp,
            'profileId' => $this->profileId,
            'profileName' => $this->profileName,
            'textures' => $this->textures
        ]);
    }
    
    public function toBase64() {
        return base64_encode($this->toJson());
    }
}
