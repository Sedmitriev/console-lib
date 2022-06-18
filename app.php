#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

array_shift($argv);
$config = yaml_parse_file(__DIR__ . '/config.yaml');

$app = new \Sedmit\CommandLib\Core\Application($config);

$app->run();
