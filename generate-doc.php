<?php 

/** davidggdev - generate OpenApi configuration to Swagger */

/** Show errors and warnigs to debug parse */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** Composer autoload */
include('vendor/autoload.php');
  
/** OpenApi generate configuration */
$openapi = \OpenApi\Generator::scan([__DIR__.'/src']);
 
/** Parse to json and save file */
file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'swagger.json',  $openapi->toJSON());