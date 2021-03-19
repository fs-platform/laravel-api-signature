<?php
return [
    [
        //签名密钥
        'signatureSecret' => env('SIGNATURE_SECRET', ''),
        //签名key
        'signatureApiKey' => env('SIGNATURE_API_KEY', ''),
        //签名有效期限秒,默认30分钟
        'timestampValidity' => 1800
    ]
];
