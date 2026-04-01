<?php

namespace App\Data;

use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Profile;
use App\Models\Token;
use App\Models\Property;
use App\Models\TexturesPayload;

class MockDataGenerator {
    public function generateUser() {
        $id = $this->generateUuid();
        $email = 'user' . rand(1000, 9999) . '@example.com';
        $properties = [
            new Property('preferredLanguage', 'zh_CN')
        ];
        
        return new User($id, $email, null, $properties);
    }
    
    public function generateProfile() {
        $id = $this->generateUuid();
        $name = 'Player' . rand(1000, 9999);
        $model = rand(0, 1) ? 'default' : 'slim';
        $properties = $this->generateTextureProperties($id, $name);
        
        return new Profile($id, $name, $model, $properties);
    }
    
    public function generateProfiles($count) {
        $profiles = [];
        for ($i = 0; $i < $count; $i++) {
            $profiles[] = $this->generateProfile();
        }
        return $profiles;
    }
    
    public function generateToken() {
        $accessToken = $this->generateUuid();
        $clientToken = $this->generateUuid();
        $issuedAt = time() * 1000;
        
        return new Token($accessToken, $clientToken, $issuedAt);
    }
    
    private function generateTextureProperties($profileId, $profileName) {
        $texturesPayload = new TexturesPayload(
            time() * 1000,
            $profileId,
            $profileName,
            [
                'SKIN' => [
                    'url' => 'https://example.com/skins/' . $profileId . '.png',
                    'metadata' => [
                        'model' => rand(0, 1) ? 'default' : 'slim'
                    ]
                ],
                'CAPE' => [
                    'url' => 'https://example.com/capes/' . $profileId . '.png'
                ]
            ]
        );
        
        $properties = [
            new Property('textures', $texturesPayload->toBase64())
        ];
        
        return $properties;
    }
    
    private function generateUuid() {
        return str_replace('-', '', Uuid::uuid4()->toString());
    }
}
