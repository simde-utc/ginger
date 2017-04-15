<?php
require 'init.php';

$ginger = new GingerMaintenance(Config::$ACCOUNTS_URL);

if(empty($argv[1])) {
    $date = date("Y-m-d", time() - 24*3600);
} else {
    $date = $argv[1];
}

echo $ginger->updateModifiedCards($date);


