<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\MockDataGenerator;

class AuthController {
    private $logger;
    private $mockDataGenerator;

    public function __construct($logger) {
        $this->logger = $logger;
        $this->mockDataGenerator = new MockDataGenerator();
    }

    public function authenticate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['username']) || !isset($data['password']) || !isset($data['agent'])) {
            return $this->error($response, 'Invalid credentials', 'Missing required fields', 401);
        }

        $token = $this->mockDataGenerator->generateToken($data['clientToken'] ?? null);
        $user = $this->mockDataGenerator->generateUser();
        $availableProfiles = $this->mockDataGenerator->generateMultipleProfiles();
        
        $responseData = [
            'accessToken' => $token->getAccessToken(),
            'clientToken' => $token->getClientToken(),
            'availableProfiles' => array_map(function($profile) {
                return $profile->toArray();
            }, $availableProfiles),
            'selectedProfile' => $token->getSelectedProfile()->toArray()
        ];

        if (isset($data['requestUser']) && $data['requestUser']) {
            $responseData['user'] = $user->toArray();
        }

        $this->logger->info('Authentication successful', ['username' => $data['username']]);
        return $this->success($response, $responseData);
    }

    public function refresh(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'Invalid token', 'Missing access token', 401);
        }

        $token = $this->mockDataGenerator->generateToken($data['clientToken'] ?? null);
        $user = $this->mockDataGenerator->generateUser();
        
        $responseData = [
            'accessToken' => $token->getAccessToken(),
            'clientToken' => $token->getClientToken(),
            'selectedProfile' => $token->getSelectedProfile()->toArray()
        ];

        if (isset($data['requestUser']) && $data['requestUser']) {
            $responseData['user'] = $user->toArray();
        }

        $this->logger->info('Token refreshed successfully');
        return $this->success($response, $responseData);
    }

    public function validate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'Invalid token', 'Missing access token', 401);
        }

        $this->logger->info('Token validated successfully');
        return $response->withStatus(204);
    }

    public function invalidate(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken'])) {
            return $this->error($response, 'Invalid token', 'Missing access token', 401);
        }

        $this->logger->info('Token invalidated successfully');
        return $response->withStatus(204);
    }

    public function signout(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['username']) || !isset($data['password'])) {
            return $this->error($response, 'Invalid credentials', 'Missing username or password', 401);
        }

        $this->logger->info('User signed out successfully', ['username' => $data['username']]);
        return $response->withStatus(204);
    }

    private function success(Response $response, $data) {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function error(Response $response, $error, $errorMessage, $statusCode = 400) {
        $errorData = [
            'error' => $error,
            'errorMessage' => $errorMessage
        ];
        $response->getBody()->write(json_encode($errorData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
}
