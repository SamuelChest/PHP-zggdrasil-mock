<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Data\MockDataGenerator;

class ProfileController {
    private $mockData;
    private $logger;
    
    public function __construct($logger) {
        $this->mockData = new MockDataGenerator();
        $this->logger = $logger;
    }
    
    private function success(Response $response, $data) {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    private function error(Response $response, $error, $errorMessage, $cause = null) {
        $errorData = [
            'error' => $error,
            'errorMessage' => $errorMessage
        ];
        
        if ($cause) {
            $errorData['cause'] = $cause;
        }
        
        $response->getBody()->write(json_encode($errorData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
    }
    
    public function getProfile(Request $request, Response $response, array $args) {
        $uuid = $args['uuid'];
        
        $profile = $this->mockData->generateProfile();
        $profile->setId($uuid);
        
        $this->logger->info('Get profile request', ['uuid' => $uuid]);
        
        return $this->success($response, $profile->toArray());
    }
    
    public function batchProfiles(Request $request, Response $response) {
        $names = $request->getParsedBody();
        
        if (!is_array($names)) {
            return $this->error($response, 'IllegalArgumentException', 'Invalid request');
        }
        
        $profiles = [];
        foreach ($names as $name) {
            $profile = $this->mockData->generateProfile();
            $profile->setName($name);
            $profiles[] = $profile->toArray(['properties' => false]);
        }
        
        $this->logger->info('Batch profiles request', ['names' => $names]);
        
        return $this->success($response, $profiles);
    }
    
    public function uploadTexture(Request $request, Response $response, array $args) {
        $uuid = $args['uuid'];
        $textureType = $args['textureType'];
        
        if (!in_array($textureType, ['skin', 'cape'])) {
            return $this->error($response, 'IllegalArgumentException', 'Invalid texture type');
        }
        
        $this->logger->info('Upload texture request', [
            'uuid' => $uuid,
            'type' => $textureType
        ]);
        
        return $response->withStatus(204);
    }
    
    public function deleteTexture(Request $request, Response $response, array $args) {
        $uuid = $args['uuid'];
        $textureType = $args['textureType'];
        
        if (!in_array($textureType, ['skin', 'cape'])) {
            return $this->error($response, 'IllegalArgumentException', 'Invalid texture type');
        }
        
        $this->logger->info('Delete texture request', [
            'uuid' => $uuid,
            'type' => $textureType
        ]);
        
        return $response->withStatus(204);
    }
}
