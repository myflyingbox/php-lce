<?php
require(__DIR__ . '/../bootstrap.php');

use \Lce\Lce;

$server = 'https://test.lce.io';
$login = 'login';
$password = 'password';

$lce = new Lce($login, $password, $server);

if($lce->check()){
  echo "Connected to ".$server." with account ".$login." successfully.\n"; 
}

