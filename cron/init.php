<?php

// Include all dependencies
require_once '../vendor/autoload.php';

// Include model
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

// Include config
require_once '../config.php';

require_once '../lib/Koala/Koala.class.php';
require_once '../class/GingerMaintenance.class.php';

