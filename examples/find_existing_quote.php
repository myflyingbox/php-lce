<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Quote;

Lce::configure('login', 'password', 'staging');

$quote = Quote::find('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');

print_r($quote);
