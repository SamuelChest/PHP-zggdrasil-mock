<?php

namespace App\Data;

use App\Models\User;
use App\Models\Profile;
use App\Models\Property;
use App\Models\Token;
use Ramsey\Uuid\Uuid;

class MockDataGenerator {
    public function generateUuid() {
        return str_replace('-', '', Uuid::uuid4()->toString());
    }

    public function generateAccessToken() {
        return $this->generateUuid() . '-' . $this->generateUuid();
    }

    public function generateUser() {
        $id = $this->generateUuid();
        $email = 'user' . rand(1000, 9999) . '@example.com';
        $properties = [new Property('preferredLanguage', 'zh_CN')];
        return new User($id, $email, null, $properties);
    }

    public function generateProfile($name = null) {
        $id = $this->generateUuid();
        $profileName = $name ?: 'Player' . rand(1000, 9999);
        $model = rand(0, 1) ? 'default' : 'slim';
        
        // Generate textures property
        $texturesPayload = [
            'timestamp' => time() * 1000,
            'profileId' => $id,
            'profileName' => $profileName,
            'textures' => [
                'SKIN' => [
                    'url' => 'https://textures.minecraft.net/texture/' . $this->generateUuid(),
                    'metadata' => [
                        'model' => $model
                    ]
                ]
            ]
        ];
        
        $texturesValue = base64_encode(json_encode($texturesPayload));
        $properties = [new Property('textures', $texturesValue)];
        
        return new Profile($id, $profileName, $model, $properties);
    }

    public function generateToken($clientToken = null, $selectedProfile = null) {
        $accessToken = $this->generateAccessToken();
        $clientToken = $clientToken ?: $this->generateUuid();
        $issuedAt = time() * 1000;
        $selectedProfile = $selectedProfile ?: $this->generateProfile();
        
        return new Token($accessToken, $clientToken, $issuedAt, $selectedProfile);
    }

    public function generateMultipleProfiles($count = 2) {
        $profiles = [];
        for ($i = 0; $i < $count; $i++) {
            $profiles[] = $this->generateProfile();
        }
        return $profiles;
    }
}
