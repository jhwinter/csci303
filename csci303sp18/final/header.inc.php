<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/01/30
 * Time: 11:28
 */

session_start();
require_once "connect.inc.php";
require_once "functions.inc.php";

//turn on error reporting for debugging - page 699
error_reporting(E_ALL);
ini_set('display_errors', '1');

//set the time zone
ini_set('date.timezone', 'America/New_York');
date_default_timezone_set('America/New_York');

//set current time
$rightnow = time();

$username = '';
if (isset($_SESSION['username'])){$username = $_SESSION['username'];}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Jonathan Winter</title>
        <link rel="stylesheet" href="styles.css"/>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    </head>
    <body class="bg-dark text-white container-fluid">
        <header>
            <h1>All About That Blockchain</h1>
            <?php require_once "nav.inc.php"; ?>
            <span class="float-right text-muted">Logged in: <?php echo $username; ?></span>
        </header>
        <main>
            <h2><?php echo $pagename; ?></h2>
