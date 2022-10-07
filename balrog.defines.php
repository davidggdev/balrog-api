<?php

/** davidggdev - Application configuration */

/**
 * Set to accept only requests from clients using https.
 * default == false
 * @var BLR_ENABLE_ONLY_HTTPS bool
 */
define('BLR_ENABLE_ONLY_HTTPS', false);

/**
 * String containing comma separated (,) allowed methods for received requests. 
 * By default only GET requests are enabled. The options are:
 *'GET' | 'GET,POST | 'POST'
 * @var BLR_REQUEST_ALLOW string
 */
define('BLR_REQUEST_ALLOW', 'GET,POST');

/**
 * MySql connection
 */
define('BLR_SQL_HOST', 'localhost');
define('BLR_SQL_DBNAME', 'poesiadb');
define('BLR_SQL_USER', 'webmaster');
define('BLR_SQL_PASSWORD', 'David2022!');