<?php
header('Access-Control-Allow-Origin:http://www.c.com');
$domain = $_POST["domain"];
die(json_encode(array("domain"=>$domain)));