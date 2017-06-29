<?php
$soap = new SoapClient("https://www.bizcn.com/rrpservices/domainService?wsdl");
echo "<pre>";
echo "function:<br>";
print_r($soap->__getFunctions());
echo "type:<br>";
print_r($soap->__getTypes());