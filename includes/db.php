<?php

//DEVELOPMENT
define('DB_USER', 'root');
define('DB_HOST', 'localhost');
define('DB_PASS', '');
define('DB_NAME', 'rate_the_prof');

//PRODUCTION
// define('DB_USER', 'xmmtfPBbY7');
// define('DB_HOST', 'remotemysql.com');
// define('DB_PASS', 'A1WgdTJRIO');
// define('DB_NAME', 'xmmtfPBbY7');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($connection == false){
    die("Service Temporarily Unavailable");
}

?>