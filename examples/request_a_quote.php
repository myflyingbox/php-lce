<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;
use \Lce\Resource\Quote;

Lce::configure('login', 'password', 'staging');

$params = array(
  'shipper' => array('postal_code' => '31300','country' => 'FR'),
  'recipient' => array('postal_code' => '06800','country' => 'FR','is_a_company' => true),
  'parcels' => array(
    array('length' => 10, 'height' => 10, 'width' => 10, 'weight' => 1),
    array('length' => 20, 'height' => 20, 'width' => 20, 'weight' => 2)
  )
);

$quote = Quote::request($params);
print_r($quote);
