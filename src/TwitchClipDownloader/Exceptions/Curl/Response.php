<?php

namespace TwitchClipDownloader\Exceptions\Curl;

class Response extends Curl {
    public function __construct($message = 'Response error', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}