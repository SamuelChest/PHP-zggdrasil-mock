<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\MockDataGenerator;

class SessionController {
    private $logger;
    private $mockDataGenerator;

    public function __construct($logger) {
        $this->logger = $logger;
        $this->mockDataGenerator = new MockDataGenerator();
    }

    public function join(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken']) || !isset($data['selectedProfile']) || !isset($data['serverId'])) {
            return $this->error($response, 'Invalid request', 'Missing required fields', 400);
        }

        $this->logger->info('Session joined successfully', [
            'selectedProfile' => $data['selectedProfile'],
            'serverId' => $data['serverId']
        ]);
        return $response->withStatus(204);
    }

    public function hasJoined(Request $request, Response $response) {
        $username = $request->getQueryParam('username');
        $serverId = $request->getQueryParam('serverId');
        $ip = $request->getQueryParam('ip');
        
        if (!$username || !$serverId) {
            return $response->withStatus(204);
        }

        $profile = $this->mockDataGenerator->generateProfile($username);
        
        $this->logger->info('Session hasJoined successful', [
            'username' => $username,
            'serverId' => $serverId,
            'ip' => $ip
        ]);
        return $this->success($response, $profile->toArray());
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
