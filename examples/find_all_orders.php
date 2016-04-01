<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Order;

Lce::configure('login', 'password', 'staging');

$orders = Order::findAll();
echo 'current page : '.$orders->current_page."\n";
echo 'total count : '.$orders->total_count."\n";
echo 'per page : '.$orders->per_page."\n";
echo 'total page : '.$orders->total_page()."\n";
echo 'next page : '.$orders->next_page()."\n";
echo 'previous page : '.$orders->previous_page()."\n";
foreach ($orders as $order) {
    echo $order->id."\n";
}
if ($orders->next_page()) {
    $orders = Order::findAll($orders->next_page());
    echo 'current page : '.$orders->current_page."\n";
    echo 'total count : '.$orders->total_count."\n";
    echo 'per page : '.$orders->per_page."\n";
    echo 'total page : '.$orders->total_page()."\n";
    echo 'next page : '.$orders->next_page()."\n";
    echo 'previous page : '.$orders->previous_page()."\n";
    foreach ($orders as $order) {
        echo $order->id."\n";
    }
}
