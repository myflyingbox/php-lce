<?php

namespace Lce\Resource;

use Lce\Lce;
use Lce\Resource\Resource;
use Lce\Resource\Offer;

class Quote extends Resource {

  function __construct($params){
    foreach ($params as $key => $value){
      if($key == 'offers'){
        $offers = array();
        foreach ($value as $offer_key => $offer){
          $offers[$offer_key] = new Offer($offer);
        }
        $this->$key = $offers;      
      } else {
        $this->$key = $value;      
      }
    }
  }

  public static function request($params) {
    $quote = Lce::$connection->post('quotes',array('quote' => $params));
    return new self($quote);    
  }
  
  public static function findAll($page = 1) {
    if($page <= 0) $page = 1;
    $quotes = Lce::$connection->get('quotes', NULL, NULL, NULL, array('page' => $page));
    foreach($quotes as $key => $quote){
      $quotes[$key] = new self($quote);
    }
    return $quotes;
  }
  
  public static function find($id) {
    $quote = Lce::$connection->get('quotes', $id);
    return new self($quote);    
  }  
   
}

