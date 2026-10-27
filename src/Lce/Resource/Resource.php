<?php

namespace Lce\Resource;

#[\AllowDynamicProperties]
class Resource
{
    public function __construct($params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }
}
