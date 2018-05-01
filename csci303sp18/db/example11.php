<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/08
 * Time: 22:02
 */

$pagename = "Example 11";
include_once "header.inc.php";

// SET INITIAL VARIABLES
$showform = 1; // show form is true

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// DELETE FROM THE DATABASE
	try
	{
		// query the data
		$sql = "DELETE FROM Categories WHERE ID = :ID";
		// prepare a statement for execution
		$stmt = $pdo->prepare($sql);
		// binds the actual value of a $_GET['ID'] to
		$stmt->bindValue(':ID', $_POST['ID']); // notice this is NOT submitted from the form
		// executes a prepared statement
		$stmt->execute();
		// hide the form
		$showform = 0;
		// provide useful confirmation to user
		echo "<p>Confirmation of deleted item No. {$_POST['ID']} - {$_POST['CategoryName']}. 
				<a href='example6.php'>Return to list<a>?</p>";
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
} // submit

// display form if show form is true
if ($showform == 1)
{
?>
	<p>Are you sure you want to delete <?php echo $_GET['CategoryName']; ?>?</p>
	<form id="deletecat" name="deletecat" method="post" action="example11.php">
		<input type="hidden" id="ID" name="ID" value="<?php echo $_GET['ID']; ?>"/>
		<input type="hidden" id="CategoryName" name="CategoryName" value="<?php echo $_GET['CategoryName']; ?>"/>
		<input type="submit" id="delete" name="delete" value="YES"/>
		<input type="button" id="nodelete" name="nodelete" value="NO" onClick="window.location='example6.php'"/>
	</form>

<?php
} // end showform
include_once "footer.inc.php";
?>