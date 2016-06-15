<?php

require 'vendor/autoload.php';

$config = require 'config/config.php';

$dbDriver = new \App\Database\Driver\MySql();
$connection = $dbDriver->connect($config['database']);

$specialDayMapper = new \Foodora\DataMapper\VendorSpecialDay($connection);
$scheduleMapper = new \Foodora\DataMapper\VendorSchedule($connection);
