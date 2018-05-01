<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/27
 * Time: 11:09
 */

$pagename = "Example 7";
include_once "header.inc.php";


try
{
    // query the data
    $sql = "SELECT * FROM Categories WHERE ID = :ID";
    // prepare a statement for execution
    $stmt = $pdo->prepare($sql);
    //binds the actual value of $_GET['ID'] to
    $stmt->bindValue(':ID', $_GET['ID']);
    // executes a prepared statement
    $stmt->execute();
    // fetches the next row from a result set / returns an array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // display to the screen
    echo $row['ID'] . "<br />" . $row['CategoryName'] . "<br />" . $row['Description'];
}
catch (PDOException $e)
{
    die($e->getMessage());
}
include_once "footer.inc.php";
?>
