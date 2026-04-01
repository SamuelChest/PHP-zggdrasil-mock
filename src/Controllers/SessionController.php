<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Profile;
use App\Data\MockDataGenerator;

class SessionController {
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
    
    public function join(Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        if (!isset($data['accessToken']) || !isset($data['selectedProfile']) || !isset($data['serverId'])) {
            return $this->error($response, 'ForbiddenOperationException', 'Invalid request');
        }
        
        $this->logger->info('Join server request', [
            'profile' => $data['selectedProfile'],
            'serverId' => $data['serverId']
        ]);
        
        return $response->withStatus(204);
    }
    
    public function hasJoined(Request $request, Response $response) {
        $params = $request->getQueryParams();
        
        if (!isset($params['username']) || !isset($params['serverId'])) {
            return $response->withStatus(204);
        }
        
        $profile = $this->mockData->generateProfile();
        $profile->setName($params['username']);
        
        $this->logger->info('Has joined request', [
            'username' => $params['username'],
            'serverId' => $params['serverId']
        ]);
        
        return $this->success($response, $profile->toArray());
    }
}
