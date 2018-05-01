<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:29
 */

echo ($currentfile == "index.php") ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
echo ($currentfile == "simpleinsert.php") ? "<li>Simple Insert</li>" : "<li><a href='simpleinsert.php'>Simple Insert</a></li>";
echo ($currentfile == "example6.php") ? "<li>Example 6</li>" : "<li><a href='example6.php'>Example 6</a></li>";
echo ($currentfile == "example8.php") ? "<li>Example 8</li>" : "<li><a href='example8.php'>Example 8</a></li>";
echo ($currentfile == "example9.php") ? "<li>Example 9</li>" : "<li><a href='example9.php'>Example 9</a></li>";
echo ($currentfile == "example10.php") ? "<li>Example 10</li>" : "<li><a href='example10.php'>Example 10</a></li>";


?>


<!--
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="concat.php">Concat</a></li>
    <li><a href="form.php">Form</a></li>
</ul>
-->