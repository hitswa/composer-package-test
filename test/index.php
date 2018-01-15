<?php

require 'vendor/autoload.php';

use Hiteshrohilla\Commons\Utility as Utility;

$utility = new Utility();
$res = $utility->generateRandomString('alphabatic',50);
echo $res;

