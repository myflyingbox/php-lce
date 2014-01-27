<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;

$env = 'staging';
$login = 'login';
$password = 'password';

$lce = new Lce($login, $password, $env);
$throw_exceptions = false;
if($lce->check($throw_exceptions)){
  echo "Connected to ".$lce->server." with account ".$login." successfully.\n"; 
}

