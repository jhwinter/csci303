<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:39
 */

$pagename = 'Update Password';
require_once "header.inc.php";
require_once "userfunctions.php";

$showform = True;
$iserror = False;
$errpassword = '';
$errpassword1 = '';

require_once "authenticate.php";
require_once "verifyrequest.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$formdata = sanitizeData($_POST);

	if (isEmptyField($formdata['password'])){$iserror=True; $errpassword='Password is required.';}
	if (isEmptyField($formdata['password1'])){$iserror=True; $errpassword1='Confirmation Password is required.';}

	if (!isMatchingField($formdata['password'], $formdata['password1'])){$iserror=True; $errpassword1='Passwords do not match';}

	// control statement to handle errors
	if ($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
	{
		if(updateUserPasswordInDB($pdo, $formdata))
		{
			$showform = False;
			echo "<p class='success'>Thanks for updating your information.</p>";
			require_once "logout.php";
		}
	}
}

if ($showform)
{
	?>
	<form name="updatepassword" id="updatepassword" method="post" action="userpasswordupdate.php">
        <table class="table table-dark table-sm table-hover table-bordered">
			<tr>
				<th><label for="password">Password:</label></th>
				<td><input type="password" name="password" id="password" size="30" class="form-control" placeholder="Required Password" required autofocus tabindex="1"/>
					<span class="error">*<?php errorMessage($errpassword); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="password1">Confirm Password:</label></th>
				<td><input type="password" name="password1" id="password1" size="30" class="form-control" placeholder="Required Confirmation Password" required tabindex="2"/>
					<span class="error">*<?php errorMessage($errpassword1); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="submit">Submit:</label></th>
				<td>
					<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
					<input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="3"/>
				</td>
			</tr>
		</table>
	</form>
	<?php
}
require_once "footer.inc.php";
?>