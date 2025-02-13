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
        'Locale' => 'id-ID',
        'SoundPackagesFolder' => '/home/anone/Documents/lib', // folder path to sound packages yang bikin saya pusing 
    ],
];
