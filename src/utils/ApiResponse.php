<?php

namespace App\Utils;

use Psr\Http\Message\ResponseInterface as Response;

class ApiResponse {
    public static function success(Response $response, $data) {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public static function error(Response $response, $error, $errorMessage, $cause = null) {
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
}
