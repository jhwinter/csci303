<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/20
 * Time: 20:20
 */

$pagename = "Content Management";
require_once "header.inc.php";
require_once "contentfunctions.php";

// set initial variables
$currentfile = basename($_SERVER['PHP_SELF']);
$iserror = False;
$showform = True;

require_once "authenticate.php";


if ($showform)
{
	$result = getAllContent($pdo);
	echo "<a href='contentadd.php'>ADD CONTENT</a><br /><br />\n";
	foreach ($result as $row) {
		echo "<a href=" . "contentview.php?id=" . $row['id'] . ">VIEW</a>: ";
		showIfCorrectUser($currentfile, "contentupdate.php", 'UPDATE', $row['id'], $row['userID']);
		showIfCorrectUser($currentfile, "contentdelete.php", 'DELETE', $row['id'], $row['userID']);
		echo $row['title'] . "<br />\n";
	}
}
require_once "footer.inc.php";
?>
