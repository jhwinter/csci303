<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:29
 */

$pagename = "Concatenation Page";
require_once "header.inc.php";

$id = 23;
$firstName = "Pablo";
$lastName = "Picasso";
echo "<img src='23.jpg' alt=' " . $firstName . " " . $lastName . " ' >";
echo "<img src='$id.jpg' alt='$firstName $lastName' >";
echo "<img src=\"$id.jpg\" alt=\"$firstName $lastName\" >";
echo '<img src=" ' . $id . '.jpg" alt=" ' . $firstName . ' ' . $lastName . ' " >';
echo '<a href="artist.php?id=' . $id .' "> ' . $firstName . ' ' . $lastName . '</a>';
echo "<p>$pagename</p>";
echo '<p>$pagename</p>';
echo $pagename . " is fabulous! <hr />";
echo $pagename . ' is fabulous!';
require_once "footer.inc.php";
?>