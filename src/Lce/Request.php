<?php

namespace Lce;

class Request extends \Httpful\Request
{
    public static function init($method = null, $mime = null)
    {
        return new self(get_object_vars(parent::init($method, $mime)));
    }

    public function send()
    {
        if (!$this->hasBeenInitialized()) {
            $this->_curlPrep();
        }

        try {
            return $this->buildResponse(curl_exec($this->_ch));
        } finally {
            $this->_ch = null;
        }
    }
}