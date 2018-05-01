<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:28
 */

require_once "connect.inc.php";
//turn on error reporting for debugging - page 699
error_reporting(E_ALL);
ini_set('display_errors', '1');

//set the time zone
ini_set('date.timezone', 'America/New_York');
date_default_timezone_set('America/New_York');

//set current time
$rightnow = time();

//current file name
$currentfile = basename($_SERVER['PHP_SELF']);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Jonathan Winters</title>
        <link rel="stylesheet" href="styles.css"/>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    </head>
    <body>
        <header>
            <h1>Linux Distros</h1>
            <nav><?php require_once "nav.inc.php"; ?></nav>
        </header>
        <main>
            <h2><?php echo $pagename; ?></h2>
