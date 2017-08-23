<?php
include_once 'Whois.php';
$sld = 'bbsunny.com';

$domain = new Phois\Whois\Whois($sld);

$whois_answer = $domain->info();

print_r($whois_answer);

if ($domain->isAvailable()) {
	echo "Domain is available\n";
} else {
	echo "Domain is registered\n";
}