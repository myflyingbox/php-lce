<?php

require __DIR__.'/../bootstrap.php';

use \Lce\Lce;
use \Lce\Resource\Quote;

Lce::configure('login', 'password', 'staging');

$quotes = Quote::findAll();
echo 'current page : '.$quotes->current_page."\n";
echo 'total count : '.$quotes->total_count."\n";
echo 'per page : '.$quotes->per_page."\n";
echo 'total page : '.$quotes->total_page()."\n";
echo 'next page : '.$quotes->next_page()."\n";
echo 'previous page : '.$quotes->previous_page()."\n";
foreach ($quotes as $quote) {
    echo $quote->id."\n";
}

$quotes = Quote::findAll($quotes->next_page());
echo 'current page : '.$quotes->current_page."\n";
echo 'total count : '.$quotes->total_count."\n";
echo 'per page : '.$quotes->per_page."\n";
echo 'total page : '.$quotes->total_page()."\n";
echo 'next page : '.$quotes->next_page()."\n";
echo 'previous page : '.$quotes->previous_page()."\n";
foreach ($quotes as $quote) {
    echo $quote->id."\n";
}
