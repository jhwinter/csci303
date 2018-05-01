<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/27
 * Time: 10:58
 */

$pagename = "Example 6";
include_once "header.inc.php";

try
{
    // query the data
    $sql = "SELECT ID, CategoryName FROM Categories ORDER BY CategoryName";
    // prepare a statement for execution
    $stmt = $pdo->prepare($sql);
    // executes a prepared statement
    $stmt->execute();
    // Returns an array containing all of the result set rows
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // display contents of array
    // print_r($result);

    // echo "<hr />";

    // loop through the results and display to the screen
    foreach ($result as $row)
    {
        echo "<a href='example7.php?ID=" . $row['ID'] . "'>VIEW</a>: ";
        echo "<a href='example11.php?ID=" . $row['ID'] . '&CategoryName=' . $row['CategoryName'] . "'>DELETE</a>: ";
        echo "<a href='example12.php?ID=" . $row['ID'] . "'>SIMPLE UPDATE</a>:";
		echo "<a href='example13.php?ID=" . $row['ID'] . "'>COMPLEX UPDATE</a>:";
		echo $row['ID'] . " - " . $row['CategoryName'] . "<br />\n";
        /*  Examples of single output (let's use ID 17, though it doesn't exist:
            <a href='example7.php?ID=17'>VIEW</a>: 17 - Some department<br />
        */
    }
}
catch (PDOException $e)
{
    die($e->getMessage());
}
include_once "footer.inc.php";
?>
