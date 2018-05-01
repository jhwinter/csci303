<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:38
 */

$pagename = 'View User';
require_once "header.inc.php";
require_once "userfunctions.php";

// set initial variables
$showform = True;
$iserror = False;
$adminstatus = 0;

require_once "authenticate.php";
require_once "verifyrequest.php";

if ($showform)
{
	$result = getUser($pdo, $_GET['id']);

	if ($result['adminStatus'] == 0) {$adminstatus = 'User is not an admin';}
	elseif ($result['adminStatus'] == 1) {$adminstatus = 'User is an admin.';}
	?>
    <div class="table-responsive">
        <table class="table table-dark table-sm table-hover table-bordered">
            <tr>
                <th>ID:</th>
                <td class="bg-secondary"><?php if (isset($result['id'])){echo $result['id'];} ?></td>
            </tr>
            <tr>
                <th>Username:</th>
                <td class="bg-secondary"><?php if (isset($result['username'])){echo $result['username'];} ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td class="bg-secondary"><?php if (isset($result['email'])){echo $result['email'];} ?></td>
            </tr>
            <tr>
                <th>Blockchain Experience:</th>
                <td class="bg-secondary"><?php if (isset($result['bio'])){echo $result['bio'];} ?></td>
            </tr>
            <tr>
                <th>Admin Status:</th>
                <td class="bg-secondary"><?php if (isset($result['adminStatus'])){echo $adminstatus;} ?></td>
            </tr>
            <tr>
                <th>Member since</th>
                <td class="bg-secondary"><?php if (isset($result['inputDate'])){echo date("d F o", $result['inputDate']);} ?></td>
            </tr>
        </table>
    </div>
	<?php
}
require_once "footer.inc.php";
?>