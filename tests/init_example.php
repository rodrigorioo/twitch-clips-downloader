<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TwitchClipDownloader\Twitch;

$gamersClubAPI = new Twitch('<your_client_id>', '<sha_256_hash>', '<id_clip>');