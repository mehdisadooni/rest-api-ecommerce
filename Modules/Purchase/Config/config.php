<?php

return [
    'name' => 'Purchase',

    'gateway' => [

        /**
         * Pay Gateway
         */

        'pay' => [
            'api' => 'test',
            'redirect' => 'http://localhost/laravel-api-project/public/payment/verify',
        ],

        /**
         * Zarinpal Gateway
         */
        'zarinpal' => [
            ''
        ]
    ]
];
