<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/20
 * Time: 11:18
 */

/* CREATE A CONNECTION TO THE SERVER */
try{
    $connString = "mysql:host=localhost;dbname=csci303sp18";
    $user = "csci303sp18";
    $pass = "csci303sp18!";
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}
?>
