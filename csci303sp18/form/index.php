<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:22
 */

$pagename = "Home page for Linux Distros";
require_once "header.inc.php";
$user = "Jonathan";
?>
            <h3>Welcome <?php echo $user; ?></h3>
            <p>The server time is <?php echo "<strong>"; echo date("z F o G:i"); echo "</strong>"; ?></p>
<?php require_once "footer.inc.php"; ?>