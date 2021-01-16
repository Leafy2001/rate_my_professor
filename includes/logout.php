<?php ob_start(); session_start(); include "db.php";

$came_from = $_SERVER['HTTP_REFERER'];

if(isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = null;
    $_SESSION['username'] = null;
    $_SESSION['user_firstname'] = null;
    $_SESSION['user_lastname'] = null;
    $_SESSION['user_email'] = null;
    $_SESSION['user_image'] = null;
    $_SESSION['user_role'] = null;
    $_SESSION['user_password'] = null;
    
}
    header("Location: $came_from");
?>