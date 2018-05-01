<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/02/20
 * Time: 11:05
 */

$pagename = "What was in that cat form?";

require_once "header.inc.php";

echo $_POST['title'];
echo "<br />\n";

echo $_POST['where'];
echo "<br />\n";

echo $_POST['username'];
echo "<br />\n";

echo $_POST['email'];
echo "<br />\n";

echo $_POST['url'];
echo "<br />\n";

echo $_POST['password'];
echo "<br />\n";

echo $_POST['radio'];
echo "<br />\n";

echo $_POST['comments'];
echo "<br />\n";

echo $_POST['hid'];
echo "<br />\n";

require_once "footer.inc.php";

?>