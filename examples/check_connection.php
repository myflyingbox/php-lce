<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;

Lce::configure('login', 'password', 'staging');

$throw_exceptions = false;

if (Lce::check($throw_exceptions)) {
    echo 'Connected to the '.Lce::env().' server '.Lce::server().' with account '.Lce::login()." successfully.\n";
}
