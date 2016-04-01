<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Order;

Lce::configure('login', 'password', 'staging');

$order = Order::find('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');
$labels_content = $order->labels();
$filename = 'labels_'.$order->id.'.pdf';
file_put_contents($filename, $labels_content);
