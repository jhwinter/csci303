<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/02/22
 * Time: 10:40
 */

//include the code for functions.inc.php
require_once "functions.inc.php";

$pagename = "Functions page";
require_once "header.inc.php";

//assign a random number
$number = rand(0, 100);

echo "<p>The original number was: " . $number . "</p>";

//obtain the number returned from the squaring function
$squarednum = squareNum($number);

//echo the squared number
echo "<p>The squared number was: " . $squarednum . "</p>";

//obtain the number returned from the doubling function
$doublednum = doubleNum($number);

//echo the doubled number
echo "<p>The doubled number was: " . $doublednum . "</p>";


include "footer.inc.php";
?>