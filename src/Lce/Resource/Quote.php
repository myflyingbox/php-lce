<?php

namespace Lce\Resource;

use Lce\Lce;
use Lce\Resource\Resource;

class Quote extends Resource {
  public static function request($params) {
    $quote = Lce::$connection->post('quotes',array('quote' => $params));
    return new self($quote);    
  }
  
  public static function find($id) {
    $quote = Lce::$connection->get('quotes', $id);
    return new self($quote);    
  }  
   
}

