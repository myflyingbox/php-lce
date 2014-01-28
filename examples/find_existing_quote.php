<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;
use \Lce\Resource\Quote;

Lce::configure('lce_fr', 'DhAcBbqRD2us8_4fwoZsdpHv3ReXqTor', 'development');

$quote = Quote::find('d517275d-2221-4574-856c-ef0ef5c6b33c');

print_r($quote);
