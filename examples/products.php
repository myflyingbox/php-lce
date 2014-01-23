<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;

$server = 'https://test.lce.io';
$login = 'login';
$password = 'password';

$lce = new Lce($login, $password, $server);
foreach($lce->products() as $product){
  echo $product->name."\n";
}


