<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/27
 * Time: 11:20
 */

$pagename = "Example 8";
include_once "header.inc.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    echo "<p>Searching for: " . $_POST['SearchTerm'] . "</p>";
    echo "<hr />";
    //create variables to store data from form - we never use POST directly w/ user input
    $formdata['SearchTerm'] = $_POST['SearchTerm'];

    try
    {
        // query the data
        $sql = "SELECT ID, CategoryName 
                FROM Categories 
                WHERE CategoryName 
                LIKE '%{$formdata['SearchTerm']}%' 
                ORDER BY CategoryName";
        // prepare a statement for execution
        $stmt = $pdo->prepare($sql);
        // executes a prepared statement
        $stmt->execute();
        // fetches the next row from a result set / returns an array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //loop through the results and display to the screen
        foreach ($result as $row)
        {
            echo "<a href='example7.php?ID=" . $row['ID'] . "'>VIEW</a>: ";
            echo $row['ID'] . " - " . $row['CategoryName'] . "<br />\n";
        }
    }
    catch (PDOException $e)
    {
        die($e->getMessage());
    }
}
?>
<form name="searchstuff" id="searchstuff" method="post" action="example8.php">
    <label for="SearchTerm">Search Categories:</label>
    <input name="SearchTerm" id="SearchTerm" type="text" />
    <input type="submit" name="submit" id="submit" value="submit" />
</form>
<?php
include_once "footer.inc.php";
?>
