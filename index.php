<?php

require 'vendor/autoload.php';

$outbox = Rhiaro\endpoint("https://rhiaro.co.uk", "outbox");
var_dump($outbox);


?>