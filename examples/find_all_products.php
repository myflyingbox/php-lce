<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Product;

Lce::configure('login', 'password', 'staging');

foreach (Product::findAll() as $product) {
    echo $product->name."\n";
}
