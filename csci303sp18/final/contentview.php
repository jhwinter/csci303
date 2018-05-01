<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:38
 */

$pagename = 'View Content';
require_once "header.inc.php";
require_once "contentfunctions.php";

// set initial variables
$showform = True;
$iserror = False;

require_once "verifyrequest.php";

$result = getContentWithUsername($pdo, $_GET['id']);
if (empty($result))
{
    $showform = False;
    echo "<p class='error'>Error: Content does not exist.</p>";
}
if ($showform)
{
	?>
    <div class="table-responsive">
        <table class="table table-dark table-sm table-hover table-bordered">
            <tr>
                <th>ID:</th>
                <td class="bg-secondary"><?php if (isset($result['id'])){echo $result['id'];} ?></td>
            </tr>
            <tr>
                <th>Title:</th>
                <td class="bg-secondary"><?php if (isset($result['title'])){echo $result['title'];} ?></td>
            </tr>
            <tr>
                <th>Category:</th>
                <td class="bg-secondary"><?php if (isset($result['category'])){echo $result['category'];} ?></td>
            </tr>
            <tr>
                <th>Details:</th>
                <td class="bg-secondary"><?php if (isset($result['details'])){echo $result['details'];} ?></td>
            </tr>
            <tr>
                <th>Author:</th>
                <td class="bg-secondary"><?php if (isset($result['userID'])){echo $result['username'];} ?></td>
            </tr>
            <tr>
                <th>Content added on:</th>
                <td class="bg-secondary"><?php if (isset($result['inputDate'])){echo date("d F o", $result['inputDate']);} ?></td>
            </tr>
        </table>
    </div>
	<?php
}
require_once "footer.inc.php";
?>