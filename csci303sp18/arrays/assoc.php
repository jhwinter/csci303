<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/02/13
 * Time: 11:44
 */

$nonsense = array("bananas" => 7, "sidewalks" => 11, "flowers" => 2, "dirt" => 187, "bleh" => 233);
echo "print_r: ";
print_r($nonsense);
echo "<br />";
echo "<br />echo values:<br />";
foreach ($nonsense as $value) {
    echo "value = " . $value . "<br />";
}
echo "<br />echo keys/values:<br />";
foreach ($nonsense as $key => $value) {
    echo "key = " . $key . " / value = " . $value . "<br />";
}
?>