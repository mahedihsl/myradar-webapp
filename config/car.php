<?php

return [
    /**
     * Gas Refuel Configuration
     *
     * count => data set size
     * factor => default price factor\
     * thresold => minimum acceptable value of (avg1 - avg2)
     */
    'refuel' => [
        'gas' => [
            'count' => 10,
            'factor' => 1.3,
            'thresold' => 15,
            'thresold2' => -10,
        ],
    ],

    'refuelByFiltering' => [
        'gas' => [
            'minBatchSize' => 20,
            'minBatchSize2' => 40,
            'factor' => 1.3,
            'minPercentage' => 80,
            'threshold' => 40,
            'threshold2' => -60,
            'minDiff' => 20,
        ],
        'fuel' => [
            'minBatchSize' => 40,
            'factor' => 1.3,
            'minPercentage' => 70,
            'threshold' => 60,
            'minDiff' => 30,
        ],
    ],
    /**
     * Geofence Configuration
     */
    'fence' => [
        'limit' => 10,
    ],

    /**
     * Mileage Configuration
     */
    'mileage' => [
        'position' => [
            'diff' => 30,
        ]
    ],

    /**
     * Gas & Fuel Meter related config
     */
    'meter' => [
        'gas' => [
            'interval' => 0,
            'min' => 20,
            'count' => 20, // min value: 18 required to gas refuel event to work
        ],
        'fuel' => [
            'interval' => 2
        ]
    ]
];
