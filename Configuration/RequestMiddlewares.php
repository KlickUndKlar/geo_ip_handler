<?php
declare(strict_types = 1);
use KK\GeoIpHandler\Middleware\RedirectionMiddleware;

return [
    'frontend' => [
        'kk/geo_ip_handler' => [
            'target' => RedirectionMiddleware::class,
            'after' => [
                'typo3/cms-frontend/tsfe',
            ],
        ],
    ],
];