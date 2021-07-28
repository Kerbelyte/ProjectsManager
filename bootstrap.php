<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\VarDumper\VarDumper;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'projects',
    'user'     => 'root',
    'password' => ''
);

$entityManager = EntityManager::create($conn, $config);

include 'db.php';

$projectsManager = new Projects\ProjectsManager($conn, $entityManager);
$employeesManager = new Employees\EmployeesManager($conn, $entityManager);