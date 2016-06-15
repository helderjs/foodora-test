<?php

require 'vendor/autoload.php';

$config = require 'config/config.php';

$dbDriver = new \App\Database\Driver\MySql();
$connection = $dbDriver->connect($config['database']);