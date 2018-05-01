<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/22
 * Time: 21:18
 */

$pagename = "Example 3";
include_once "header.inc.php";

try
{
    // query the data
    $sql = "SELECT * FROM Categories";
    // prepare a statement for execution
    $stmt = $pdo->prepare($sql);
    // executes a prepared statement
    $stmt->execute();
    // fetches the next row from a result set / returns an array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // display contents of array
    print_r($row);
    echo "<hr />";

    // display to the screen
    echo $row['ID'] . " - " . $row['CategoryName'] . "<br />";
}
catch (PDOException $e)
{
    die($e->getMessage());
}
include_once "footer.inc.php";
?>