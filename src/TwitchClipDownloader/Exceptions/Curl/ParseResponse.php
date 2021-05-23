<?php

namespace TwitchClipDownloader\Exceptions\Curl;

class ParseResponse extends Curl {
    public function __construct($message = 'Parse response error', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}