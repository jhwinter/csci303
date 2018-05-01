<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/02/22
 * Time: 11:29
 */

$pagename = "Functions Home";
include_once "header.inc.php";

//function that returns a value
function getNiceTime()
{
    return date("H:i:s");
}

function ouputStuff()
{
    echo "<hr />xxxxxxxxxxxSTUFF<hr />";
}
?>