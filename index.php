<?php

/** TODO
 *  [] MYSQL
 *  [] REDIS 
 */

/** davidggdev - main index controller */

/* Comment in production */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** Header response document */
header('Content-Type: application/json');

/** App defines configuration */
include('balrog.defines.php');

/** Composer autoload */
include('vendor/autoload.php');
 
/** Action uri =>  */
$endpoints = [
    '/get' => ['SampleEntryPoint', 'get']
];

/** Run! */
$BalrogTest = new Balrog\Handler($endpoints); 