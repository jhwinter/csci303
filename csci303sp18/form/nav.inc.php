<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:29
 */

echo ($currentfile == "index.php") ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
echo ($currentfile == "concat.php") ? "<li>Concat</li>" : "<li><a href='concat.php'>Concat</a></li>";
echo ($currentfile == "form.php") ? "<li>Form</li>" : "<li><a href='form.php'>Form</a></li>";
echo ($currentfile == "simpleform.php") ? "<li>Simple Form</li>" : "<li><a href='simpleform.php'>Simple Form</a></li>";

?>


<!--
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="concat.php">Concat</a></li>
    <li><a href="form.php">Form</a></li>
</ul>
-->