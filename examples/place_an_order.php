<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Quote;
use \Lce\Resource\Order;

Lce::configure('login', 'password', 'staging');

$quote = Quote::find('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');
$offer = $quote->offers[0];

$params = array(
  'shipper' => array(
    'company' => 'company name',
    'name' => 'shipper name',
    'street' => "street line 1\nstreet line 2",
    'city' => 'city',
    'state' => 'state',
    'phone' => '0123456789',
    'email' => 'test@emailshipper.com',
  ),
  'recipient' => array(
    'company' => 'company name',
    'name' => 'recipient name',
    'street' => "street line 1\nstreet line 2",
    'city' => 'city',
    'state' => 'state',
    'phone' => '0123456789',
    'email' => 'test@emailshipper.com',
  ),
  'parcels' => array(
    array('description' => 'An item', 'value' => 100, 'currency' => 'EUR'),
    array('description' => 'An other item', 'value' => 20, 'currency' => 'EUR'),
  ),
);

$order = Order::place($offer->id, $params);
# or
# $order = $offer->order($params);

print_r($order);
