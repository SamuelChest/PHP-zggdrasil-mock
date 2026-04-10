<?php

// Configuration for Yggdrasil API Server

return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'hademo',
        'password' => 'hademo',
        'database' => 'hademo'
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
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvtjnFD4Y6x8DBO51XgYI
wqrxNSL5Sydf6/eeJ7xfSpvk6YNJtbMPdjBiKUugHBbkNWsK06ypcdk2MCnQDosg
xmqfrFEi/mpakMgMMVALV/ny/49eo4tlJR0f3kvSaAlUDoGT0AjS/2meEXKy1GVj
9iI28Fphclv7jq1xTw3eCMveZZptCHg/ejgtyBcimdo2mn/HTpT2CYwAhppJAg+b
XgAitpMveEKN54gPMbmaxpOECsyZ3EujMzHsWjn+HeThwtLkWGoQiRPIzaAsBt1m
up+koPDK1ADs0EWUBlxvOgVh7WTwQYqcW/xgGTrAACXjR5vaT78tmtilukFdTDMc
AQIDAQAB
-----END PUBLIC KEY-----
'
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
