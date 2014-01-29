<?php

namespace Lce\Resource;

use Lce\Lce;
use Lce\Resource\Resource;

class Order extends Resource {

  public static function place($offer_id, $params) {
    $params['offer_id'] = $offer_id;
    $order = Lce::$connection->post('orders',array('order' => $params));
    return new self($order);    
  }
  
  public static function find($id) {
    $order = Lce::$connection->get('orders', $id);
    return new self($order);    
  }  

  public static function findAll($page = 1) {
    if($page <= 0) $page = 1;
    $orders = Lce::$connection->get('orders', NULL, NULL, NULL, array('page' => $page));
    foreach($orders as $key => $order){
      $orders[$key] = new self($order);
    }
    return $orders;
  }

  public function labels() {
    $labels = Lce::$connection->get('orders', $this->id, 'labels', 'pdf');
    return $labels; 
  } 

  public function tracking() {
    $tracking = Lce::$connection->get('orders', $this->id, 'tracking');
    return $tracking; 
  } 
     
}

