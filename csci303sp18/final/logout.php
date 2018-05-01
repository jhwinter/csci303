<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/19
 * Time: 13:36
 */

session_start();
session_unset();
session_destroy();
header("Location: confirm.php?state=1");
exit();

?>