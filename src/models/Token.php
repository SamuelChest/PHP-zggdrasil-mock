<?php

namespace App\Models;

class Token {
    private $accessToken;
    private $clientToken;
    private $selectedProfile;
    private $issuedAt;
    private $expiresInDays;
    private $state;

    public function __construct($accessToken, $clientToken, $issuedAt, $selectedProfile = null, $expiresInDays = 15, $state = 'valid') {
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

    public function toArray() {
        $array = [
            'accessToken' => $this->accessToken,
            'clientToken' => $this->clientToken,
            'issuedAt' => $this->issuedAt,
            'expiresInDays' => $this->expiresInDays,
            'state' => $this->state
        ];
        if ($this->selectedProfile) {
            $array['selectedProfile'] = $this->selectedProfile->toArray();
        }
        return $array;
    }
}
