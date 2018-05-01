<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/25
 * Time: 00:07
 */

require_once "functions.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']))
{
	$id = $_GET['id'];
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']))
{
	$id = $_POST['id'];
}
else
{
	$iserror = True;
	$showform = False;
	echo "<p class='error'>Something happened! Cannot obtain the correct entry.</p>";
}
?>