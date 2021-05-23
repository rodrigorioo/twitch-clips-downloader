<?php

use TwitchClipDownloader\Exceptions\Clip\Clip;
use TwitchClipDownloader\Exceptions\Clip\Save;
use TwitchClipDownloader\Exceptions\Curl\Curl;

include('init.php');

try {
    $twitch->download('AwkwardSmilingHawkRiPepperonis-HM_5YxqeVMtk-yam')
        ->save();
} catch (Curl | Save | Clip $e) {
    echo $e->getMessage();
    exit();
}

var_dump($twitch);