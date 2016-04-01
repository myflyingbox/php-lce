<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Order;

Lce::configure('login', 'password', 'staging');

$order = Order::find('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');
$tracking = $order->tracking();

print_r($tracking);
