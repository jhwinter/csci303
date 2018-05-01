<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/22
 * Time: 21:21
 */

$pagename = "Example 4";
include_once "header.inc.php";

try
{
    // query the data
    $sql = "SELECT * FROM Categories ORDER BY CategoryName";
    // prepare a statement for execution
    $stmt = $pdo->prepare($sql);
    // executes a prepared statement
    $stmt->execute();
    // Returns an array containing all of the result set rows
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // display contents of array
    print_r($result);

    echo "<hr />";

    // loop through the results and display to the screen
    foreach ($result as $row)
    {
        echo $row['ID'] . " - " . $row['CategoryName'] . "<br />";
    }
}
catch (PDOException $e)
{
    die($e->getMessage());
}
include_once "footer.inc.php";
?>