<?php

/**
 * ipv4  正则
 * @var string $IP
 */
$IP = "1.168.1.78";
$ipv4 = "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/";
$result = preg_match($ipv4,$IP);
var_dump($result);

/**
 * ipv6 正则
 */

$ipv6 = "/\A
(?:
(?:
(?:[a-f0-9]{1,4}:){6}
|
::(?:[a-f0-9]{1,4}:){5}
|
(?:[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){4}
|
(?:(?:[a-f0-9]{1,4}:){0,1}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){3}
|
(?:(?:[a-f0-9]{1,4}:){0,2}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){2}
|
(?:(?:[a-f0-9]{1,4}:){0,3}[a-f0-9]{1,4})?::[a-f0-9]{1,4}:
|
(?:(?:[a-f0-9]{1,4}:){0,4}[a-f0-9]{1,4})?::
)
(?:
[a-f0-9]{1,4}:[a-f0-9]{1,4}
|
(?:(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\.){3}
(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])
)
|
(?:
(?:(?:[a-f0-9]{1,4}:){0,5}[a-f0-9]{1,4})?::[a-f0-9]{1,4}
|
(?:(?:[a-f0-9]{1,4}:){0,6}[a-f0-9]{1,4})?::
)
)\Z/ix";
$result = preg_match($ipv6,"0:0:0:0:0:ffff:7819:d952");
var_dump($result);
