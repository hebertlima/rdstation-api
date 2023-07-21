<?php

\error_reporting(E_ALL);

include_once dirname(__DIR__) . '/vendor/autoload.php';

if (!class_exists('Dotenv\Dotenv')) {
    throw new RuntimeException('Dotenv\Dotenv is missing.');
}

$rootDir = dirname(__DIR__) . '/';
$dotenv = \Dotenv\Dotenv::createImmutable($rootDir, '.env.test');
$dotenv->load();