<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/24
 * Time: 22:05
 */

require_once "functions.inc.php";

if (isset($_SESSION['id']))
{
	$userID = $_SESSION['id'];
}
else
{
	$iserror = True;
	$showform = False;
	echo "<p class='error'>Cannot view this page. Please log in.</p>";
}