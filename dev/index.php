<?php

echo 'Dit is een test - Voor de require<br />';

require_once('./templates/head.inc.php');

echo 'Dit is een test - Na de eerste require<br />';

require_once('./templates/foot.inc.php');

echo 'Dit is een test - Na de require van de footer';