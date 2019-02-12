<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:38
 */

$pagename = 'Update User';
require_once "header.inc.php";
require_once "userfunctions.php";

// set initial variables
$showform = True;
$iserror = False;
$errusername = '';
$erremail = '';
$errbio = '';

require_once "authenticate.php";
require_once "verifyrequest.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$formdata = sanitizeData($_POST);

	if (isEmptyField($formdata['username'])){$iserror=True; $errusername='Username is required.';}
	if (isEmptyField($formdata['email'])){$iserror=True; $erremail='Email is required.';}
	if (isEmptyField($formdata['bio'])){$iserror=True; $errbio='Blockchain experience is required.';}

	if (isMatchingField($formdata['username'], $formdata['origusername']) == False)
	{
		if (isDuplicate($pdo, 'jhwinterUser', 'username', $formdata['username']))
		{
			$iserror = True;
			$errusername = 'Username already exists in the database.';
		}
	}
	if (isMatchingField($formdata['email'], $formdata['origemail']) == False)
	{
		if (isDuplicate($pdo, 'jhwinterUser', 'email', $formdata['email']))
		{
			$iserror = True;
			$erremail = 'Email already exists in the database.';
		}
	}

	// control statement to handle errors
	if ($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
	{
		updateUserInDB($pdo, $formdata);
		$showform = False;
		echo "<p class='success'>Thanks for updating your information.</p>";
	}
}

if ($showform)
{
	$result = getUser($pdo, $id);
	?>
	<form name="updateuser" id="updateuser" method="post" action="userupdate.php">
		<table class="table table-dark table-sm table-hover table-bordered">
			<tr>
				<th><label for="username">Username:</label></th>
				<td><input type="text" name="username" id="username" size="30" class="form-control" placeholder="Required Username"
						   value="<?php if (isset($formdata['username']) && !empty($formdata['username']))
						   {echo $formdata['username'];} else {echo $result['username'];} ?>" required autofocus tabindex="1"/>
					<span class="error">*<?php errorMessage($errusername); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="email">Email:</label></th>
				<td><input type="text" name="email" id="email" size="30" class="form-control" placeholder="Required Email"
						   value="<?php if (isset($formdata['email']) && !empty($formdata['email']))
						   {echo $formdata['email'];} else {echo $result['email'];} ?>" required tabindex="2"/>
					<span class="error">*<?php errorMessage($erremail); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="bio">Blockchain Experience:</label></th>
				<td>
					<span class="error">*<?php errorMessage($errbio); ?></span>
					<textarea name="bio" id="bio" class="form-control" placeholder="Required Bio" required tabindex="3">
					<?php if (isset($formdata['bio']) && !empty($formdata['bio'])) {
						echo $formdata['bio'];
					} else {
						echo $result['bio'];} ?>
				</textarea>
				</td>
			</tr>
			<tr>
				<th><label for="submit">Submit:</label></th>
				<td>
					<input type="hidden" name="id" id="id" value="<?php echo $result['id']; ?>"/>
					<input type="hidden" name="origusername" id="origusername" value="<?php echo $result['username']; ?>"/>
					<input type="hidden" name="origemail" id="origemail" value="<?php echo $result['email']; ?>"/>
					<input type="hidden" name="origbio" id="origbio" value="<?php echo $result['bio']; ?>"/>
					<input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="4"/>
				</td>
			</tr>
		</table>
	</form>
	<?php
}
require_once "footer.inc.php";
?>
