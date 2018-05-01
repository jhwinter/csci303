<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/20
 * Time: 20:05
 */

$pagename = "User Management";
require_once "header.inc.php";
require_once "userfunctions.php";

$currentfile = basename($_SERVER['PHP_SELF']);
$showform = True;
$iserror = False;

require_once "authenticate.php";


if ($showform == True && $iserror == False)
{
	$result = getAllUsers($pdo);
	foreach ($result as $row)
	{
		echo "<a href=" . "userview.php?id=" . $row['id'] . ">VIEW</a>: ";
		showIfCorrectUser($currentfile, "userupdate.php", 'UPDATE', $row['id']);
		showIfCorrectUser($currentfile, "userpasswordupdate.php", 'CHANGE PASSWORD', $row['id']);
		echo $row['username'] . "<br />\n";
	}
}

require_once "footer.inc.php";
?>
