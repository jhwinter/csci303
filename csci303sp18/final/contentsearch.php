<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/25
 * Time: 01:43
 */

$pagename = "Search Content";
require_once "header.inc.php";
require_once "contentfunctions.php";

//set initial variables
$showform = True; // show form is true
$iserror = False;
$errsearch = '';
$searchterm = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$searchterm = $_POST['searchterm'];
	echo "<p>Searching for: " . $searchterm . "</p>";
	echo "<hr />";
	//create variables to store data from form - we never use POST directly w/ user input
	$result = searchContentInDB($pdo, $searchterm);
	if (empty($result))
	{
		$iserror = True;
		$errsearch = "<p class='error'>Search term does not match any categories. Would you like to try again?</p>";
	}
	else
	{
		$showform = False;
		echo "<p>Here are the results:</p>";
		echo "<ol>";
		foreach ($result as $row)
		{
			echo "<li><a href=" . "contentview.php?id=" . $row['id'] . ">VIEW</a>: ";
			echo $row['id'] . " - " . $row['title'] . "</li>\n";
		}
		echo "</ol>";
	}
}

// display form if Show Form flag is true
if ($showform)
{
	?>
	<form name="contentsearch" id="contentsearch" method="post" action="contentsearch.php" class="form-group">
		<label for="searchterm">Search Content:</label>
		<input name="searchterm" id="searchterm" class="form-control" type="text" tabindex="1" required autofocus/>
		<input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="2"/>
		<span><?php errorMessage($errsearch); ?></span>
	</form>
	<?php
} // end showform
include_once "footer.inc.php";
?>
