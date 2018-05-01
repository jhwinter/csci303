<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/22
 * Time: 11:15
 */

$pagename = "Example 1";
include_once "header.inc.php";

try
{
    // query the data
    $sql = "SELECT * FROM Categories ORDER BY CategoryName";
    // executes a query
    $result = $pdo->query($sql);

    // loop through the results and display to the screen
    foreach ($result as $row) {
        echo $row['ID'] . " - " . $row['CategoryName'] . "<br />";
    }
}
catch (PDOException $e)
{
    die($e->getMessage());
}
include_once "footer.inc.php";
?>
