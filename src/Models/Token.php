<?php

namespace App\Models;

class Token {
    private $accessToken;
    private $clientToken;
    private $selectedProfile;
    private $issuedAt;
    private $expiresInDays;
    private $state;
    
    public function __construct($accessToken, $clientToken, $issuedAt, $expiresInDays = 15, $state = 'valid', $selectedProfile = null) {
        $this->accessToken = $accessToken;
        $this->clientToken = $clientToken;
        $this->selectedProfile = $selectedProfile;
        $this->issuedAt = $issuedAt;
        $this->expiresInDays = $expiresInDays;
        $this->state = $state;
    }
    
    public function getAccessToken() {
        return $this->accessToken;
    }
    
    public function getClientToken() {
        return $this->clientToken;
    }
    
    public function getSelectedProfile() {
        return $this->selectedProfile;
    }
    
    public function getIssuedAt() {
        return $this->issuedAt;
    }
    
    public function getExpiresInDays() {
        return $this->expiresInDays;
    }
    
    public function getState() {
        return $this->state;
    }
}
