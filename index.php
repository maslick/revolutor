<?php

include 'revolut.cfg.php';

if(isset($_GET['code'])) $revolut->exchangeCodeForAccessToken();

print "<pre>";

print "<h2>accounts</h2>\n";
print_r($revolut->accounts());

print "<h2>counterparties</h2>\n";
print_r($revolut->counterparties());

print "<h2>getExchangeRate</h2>\n";
print_r($revolut->getExchangeRate(['from'=>'USD', 'to'=>'EUR']));
print_r($revolut->getExchangeRate(['from'=>'EUR', 'to'=>'USD']));

print "<h2>transactions</h2>\n";
print_r($revolut->transactions());

print "</pre>";