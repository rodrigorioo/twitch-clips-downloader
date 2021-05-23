<?php

namespace TwitchClipDownloader\Exceptions\Clip;

class Save extends Clip {
    public function __construct($message = 'Save clip error', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}