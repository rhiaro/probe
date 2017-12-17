<?php

require 'vendor/autoload.php';

$outbox = Rhiaro\endpoint("https://rhiaro.co.uk/#me", "https://www.w3.org/ns/activitystreams#outbox");
echo $outbox;


?>