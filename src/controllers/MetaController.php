<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class MetaController {
    private $logger;

    public function __construct($logger) {
        $this->logger = $logger;
    }

    public function index(Request $request, Response $response) {
        $metaData = [
            'meta' => [
                'serverName' => 'Yggdrasil Mock Server',
                'implementationName' => 'PHP Yggdrasil Mock',
                'implementationVersion' => '1.0.0',
                'links' => [
                    'homepage' => 'https://example.com',
                    'register' => 'https://example.com/register'
                ]
            ],
            'skinDomains' => [
                'textures.minecraft.net',
                '*.example.com'
            ],
            'signaturePublickey' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA...
-----END PUBLIC KEY-----'
        ];
        
        $this->logger->info('Meta endpoint accessed');
        $response->getBody()->write(json_encode($metaData));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
