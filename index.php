<?php

require 'vendor/autoload.php';

$config = require 'config/config.php';

$dbDriver = new \App\Database\Driver\MySql();
$connection = $dbDriver->connect($config['database']);

$specialDayMapper = new \Foodora\DataMapper\VendorSpecialDay($connection);
$scheduleMapper = new \Foodora\DataMapper\VendorSchedule($connection);

if ($argv[1] == 'fix') {
    $command = new \Foodora\Command\FixSchedule(
        $scheduleMapper,
        $specialDayMapper,
        new DateTime($argv[2]),
        new DateTime($argv[3]),
        $argv[4]
    );
} elseif ('restore') {
    $command = new \Foodora\Command\RestoreSchedule(
        $scheduleMapper,
        $argv[2]
    );
} else {
    die ("None command to run.\n");
}

$connection->beginTransaction();

try {
    $command->execute();

    $connection->commit();
} catch (Exception $e) {
    $connection->rollback();
    
    echo $e->getMessage() . "\n";
}