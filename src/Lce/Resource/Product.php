<?php

namespace Lce\Resource;

use Lce\Lce;
use Lce\Resource\Resource;

class Product extends Resource {
  public static function findAll() {
    $products = Lce::$connection->get('products');
    foreach($products as $key => $product){
      $products[$key] = new self($product);
    }
    return $products;
  }
}

