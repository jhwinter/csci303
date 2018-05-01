<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/27
 * Time: 11:56
 */

$pagename = "Example 8a";
include_once "header.inc.php";

//set initial variables
$showform = 1; // show form is true
$errorval = 0;
$errormsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
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

        /*
         * If there are no entries, let the user know and DO NOT hide the form.
         *  - Ask them if they would like to try again.
         * Else loop through and display the entries
         *  - Write all of the code necessary to hide the form!
         */
		$countresults = $stmt->rowCount();
		if ($countresults < 1)
		{
			$errorval = 1; // there is an error
			$errormsg = "<p class='error'>Search term does not match any categories. Would you like to try again?</p>";
		}
		else
        {
            $showform = 0; // do not show form
            echo "<p>Here are the results:</p>";
			//loop through the results and display to the screen
			foreach ($result as $row)
			{
				echo "<a href='example7.php?ID=" . $row['ID'] . "'>VIEW</a>: ";
				echo $row['ID'] . " - " . $row['CategoryName'] . "<br />\n";
			}
        }
	}
	catch (PDOException $e)
    {
		die($e->getMessage());
	}
} // submit

// display form if Show Form flag is true
if ($showform == 1)
{
?>
<form name="searchstuff" id="searchstuff" method="post" action="example8a.php">
    <label for="SearchTerm">Search Categories:</label>
    <input name="SearchTerm" id="SearchTerm" type="text" tabindex="1" />
    <input type="submit" name="submit" id="submit" value="submit" tabindex="2" />
    <span><?php if(isset($errormsg)){echo $errormsg;}?></span>
</form>
<?php
} // end showform
include_once "footer.inc.php";
?>
