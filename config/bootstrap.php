<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once getcwd() . '/vendor/autoload.php';

$isDevMode = true;
$paths = array(getcwd() . '/models');

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'todo',
    'user' => 'todo',
    'password' => 'DFGdrg45$##$dfg',
    'host' => 'localhost',
    'port' => 3306,
    'charset' => 'utf8mb4',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);