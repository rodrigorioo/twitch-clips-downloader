<?php

namespace TwitchClipDownloader\Exceptions\Clip;

class Clip extends \Exception {
    public function __construct($message = 'Clip error', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

