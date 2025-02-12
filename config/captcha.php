<?php

if (!class_exists('CaptchaConfiguration')) {
    return;
}

return [
    'LoginCaptcha' => [
        'UserInputID' => 'CaptchaCode',
        'ImageWidth' => 250,
        'ImageHeight' => 50,
        'ImageStyle' => [
            'Graffiti',
            'GraffitiStreetSign',
        ],
    ],
];
