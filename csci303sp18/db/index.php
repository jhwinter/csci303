<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/30
 * Time: 11:22
 */

$pagename = "Database Connections";
require_once "header.inc.php";
$user = "Jonathan";
?>
    <h3>Welcome <?php echo $user; ?></h3>
    <p>Now we learn about interacting with the database.</p>
    <p>The server time is <?php echo "<strong>"; echo date("d F o G:i"); echo "</strong>"; ?></p>
<?php include_once "footer.inc.php"; ?>