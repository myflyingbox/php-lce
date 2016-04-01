<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Quote;

Lce::configure('login', 'password', 'staging');

$quote = Quote::find('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');

$params = array(
  'street' => 'street line1\nstreet line2\n',
  'city' => 'city name',
);

if ($quote->offers[1]->product->preset_delivery_location == true) {
    $locations = $quote->offers[1]->available_delivery_locations($params);
    print_r($locations);
}
