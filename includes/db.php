<?php

//DEVELOPMENT
define('DB_USER', 'root');
define('DB_HOST', 'localhost');
define('DB_PASS', '');
define('DB_NAME', 'rate_the_prof');

//PRODUCTION
// define('DB_USER', '2kWWEPFoqD');
// define('DB_HOST', 'remotemysql.com');
// define('DB_PASS', 'yVWEqsY8Z5');
// define('DB_NAME', '2kWWEPFoqD');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($connection == false){
    die("Service Temporarily Unavailable");
}

?>