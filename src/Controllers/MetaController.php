<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MetaController {
    private $logger;
    
    public function __construct($logger) {
        $this->logger = $logger;
    }
    
    private function success(Response $response, $data) {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function index(Request $request, Response $response) {
        $metaData = [
            'meta' => [
                'serverName' => 'PHP Yggdrasil Mock',
                'implementationName' => 'php-zggdrasil-mock',
                'implementationVersion' => '1.0.0',
                'links' => [
                    'homepage' => 'https://github.com/example/php-zggdrasil-mock',
                    'register' => 'https://example.com/register'
                ]
            ],
            'skinDomains' => [
                'example.com',
                'skins.example.com'
            ],
            'signaturePublickey' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA...
-----END PUBLIC KEY-----'
        ];
        
        $this->logger->info('Meta endpoint request');
        
        return $this->success($response, $metaData);
    }
}
