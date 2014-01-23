<?php

namespace Lce\Resource;

class Resource {
  function __construct($params){
    foreach ($params as $key => $value)
    {
      $this->$key = $value;
    }
  }
}

