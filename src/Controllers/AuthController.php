<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\User;
use App\Models\Profile;
use App\Models\Token;
use App\Data\MockDataGenerator;

class AuthController {
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
    
    public function authenticate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        // Validate required fields
        if (!isset($data['username']) || !isset($data['password']) || !isset($data['agent'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid credentials');
        }
        
        // Generate mock response
        $user = $this->mockData->generateUser();
        $profiles = $this->mockData->generateProfiles(2);
        $token = $this->mockData->generateToken();
        
        $responseData = [
            'accessToken' => $token->getAccessToken(),
            'clientToken' => $token->getClientToken(),
            'availableProfiles' => array_map(function($profile) {
                return $profile->toArray();
            }, $profiles),
            'selectedProfile' => $profiles[0]->toArray(),
            'user' => $user->toArray()
        ];
        
        $this->logger->info('Authenticate request', ['username' => $data['username']]);
        return $this->success($response, $responseData);
    }
    
    public function refresh(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid token');
        }
        
        $token = $this->mockData->generateToken();
        $profile = $this->mockData->generateProfile();
        $user = $this->mockData->generateUser();
        
        $responseData = [
            'accessToken' => $token->getAccessToken(),
            'clientToken' => $token->getClientToken(),
            'selectedProfile' => $profile->toArray(),
            'user' => $user->toArray()
        ];
        
        $this->logger->info('Refresh token request');
        return $this->success($response, $responseData);
    }
    
    public function validate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid token');
        }
        
        $this->logger->info('Validate token request');
        return $response->withStatus(204);
    }
    
    public function invalidate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid token');
        }
        
        $this->logger->info('Invalidate token request');
        return $response->withStatus(204);
    }
    
    public function signout(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['username']) || !isset($data['password'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid credentials');
        }
        
        $this->logger->info('Signout request', ['username' => $data['username']]);
        return $response->withStatus(204);
    }
}
