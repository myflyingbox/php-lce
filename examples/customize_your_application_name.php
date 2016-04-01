<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Quote;

$api = Lce::configure('login', 'password', 'staging');
$api->application = 'my_custom_lce_client';
$api->application_version = '1.0.5';

$params = array(
  'shipper' => array('postal_code' => '31300', 'city' => 'Toulouse', 'country' => 'FR'),
  'recipient' => array('postal_code' => '06800', 'city' => 'Cagnes-sur-mer', 'country' => 'FR', 'is_a_company' => true),
  'parcels' => array(
    array('length' => 10, 'height' => 10, 'width' => 10, 'weight' => 1),
    array('length' => 20, 'height' => 20, 'width' => 20, 'weight' => 2),
  ),
);

$quote = Quote::request($params);
print_r($quote);
