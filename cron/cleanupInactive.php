<?php
require 'init.php';

$ginger = new GingerMaintenance(Config::$ACCOUNTS_URL);

echo $ginger->cleanupLoginsWithoutActiveCards();


