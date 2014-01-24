<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;

$env = 'staging';
$login = 'login';
$password = 'password';

$lce = new Lce($login, $password, $env);
foreach($lce->products() as $product){
  echo $product->name."\n";
}


