<?php

// Configuration for Yggdrasil API Server

return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'yggdrasil_api',
        'password' => 'yggdrasil_api',
        'database' => 'yggdrasil_api'
    ],
    'server' => [
        'name' => 'Yggdrasil Mock Server',
        'implementation' => 'PHP Yggdrasil Mock',
        'version' => '1.0.0',
        'links' => [
            'homepage' => 'http://auth.samuelchest.com/',
            'register' => 'http://auth.samuelchest.com/register'
        ],
        'skin_domains' => [
            'auth.samuelchest.com',
            '.samuelchest.com'
        ],
        'signature_public_key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA...
-----END PUBLIC KEY-----'
    ],
    'security' => [
        'token_expiry_days' => 15,
        'session_expiry_seconds' => 30,
        'password_cost' => 10
    ],
    'feature_flags' => [
        'non_email_login' => false,
        'legacy_skin_api' => true,
        'no_mojang_namespace' => false,
        'enable_mojang_anti_features' => false,
        'enable_profile_key' => false,
        'username_check' => true
    ]
];
