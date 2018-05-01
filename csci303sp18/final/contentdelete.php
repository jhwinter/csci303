<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:40
 */

$pagename = 'Delete Content';
require_once "header.inc.php";
require_once "contentfunctions.php";

// set initial variables
$showform = True;
$iserror = False;
$id = 0;
$result = array();

require_once "authenticate.php";
require_once "verifyrequest.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (deleteContentInDB($pdo, $_POST['id']))
	{
		$showform = False;
		// provide useful confirmation to user
		echo "<p>Confirmation of deleted item No." . $_POST['id'] . " - " . $_POST['title'] . " " .
			"<a href='index.php'>Return to list<a>?</p>";
	}
}
if ($showform == True)
{
    $result = getContent($pdo, $id);
	?>
	<p>Are you sure you want to delete <?php echo $result['title']; ?>?</p>
	<form id="deletecontent" name="deletecontent" method="post" action="contentdelete.php">
		<input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>"/>
		<input type="hidden" id="title" name="title" value="<?php echo $result['title']; ?>"/>
		<input type="submit" id="delete" name="delete" value="YES" class="btn btn-danger" tabindex="1"/>
		<input type="button" id="nodelete" name="nodelete" value="NO" onClick="window.location='index.php'" class="btn" tabindex="2"/>
	</form>
<?php
}
require_once "footer.inc.php";
?>