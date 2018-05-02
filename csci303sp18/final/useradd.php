<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/20
 * Time: 20:21
 */

$pagename = "User Registration";
require_once "header.inc.php";
require_once "userfunctions.php";

//SET INITIAL VARIABLES
$showform = True;
$iserror = False;
$errusername = '';
$erremail = '';
$erremail1 = '';
$errpassword = '';
$errpassword1 = '';
$errbio = '';
$formdata = array();


if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$formdata = sanitizeData($_POST); // sanitize user data

    // check for empty fields
	if (isEmptyField($formdata['username']))
	{
		$iserror = True;
		$errusername = 'Username is required.';
	}
	if (isEmptyField($formdata['email']))
	{
		$iserror = True;
		$erremail = 'Email is required';
	}
	if (isEmptyField($formdata['email1']))
	{
		$iserror = True;
		$erremail1 = 'Confirmation email is required.';
	}
	if (isEmptyField($formdata['password']))
	{
		$iserror = True;
		$errpassword = 'Password is required.';
	}
	if (isEmptyField($formdata['password1']))
	{
		$iserror = True;
		$errpassword1 = 'Confirmation password is required.';
	}
	if (isEmptyField($formdata['bio']))
	{
		$iserror = True;
		$errbio = 'Bio is required.';
	}

	// verify that password and email fields match
	if (isMatchingField($formdata['email'], $formdata['email1']) == False)
	{
		$iserror = True;
		$erremail1 = 'The emails do not match.';
	}
	if (isMatchingField($formdata['password'], $formdata['password1']) == False)
	{
		$iserror = True;
		$errpassword1 = 'The passwords do not match.';
	}

	// check for duplicate usernames/emails
	if (isDuplicate($pdo, 'jtwintersUser', 'username', $formdata['username']))
	{
		$iserror = True;
		$errusername = 'Username already exists.';
	}
	if (isDuplicate($pdo, 'jtwintersUser', 'email', $formdata['email']))
	{
		$iserror = True;
		$erremail = 'Email already exists.';
	}

	// control statement to handle errors
	if ($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
	{
		$hashedpassword = hashPassword($formdata['password']);
		if(insertUserIntoDB($pdo, $formdata, $hashedpassword, $rightnow))
		{
			$showform = False;
			echo "<p class='success'>Thanks for entering your information.</p>";
		}
	} // end of else control statement
} // end of if request method is post
if ($showform)
{
?>
	<form name="adduser" id="adduser" method="post" action="useradd.php">
		<table class="table table-bordered table-hover table-dark table-sm">
			<tr>
				<th><label for="username">Username:</label></th>
				<td><input type="text" name="username" id="username" size="30" class="form-control" placeholder="Required Username"
						   value="<?php if (isset($formdata['username'])) {
						       echo $formdata['username'];} ?>" required autofocus tabindex="1"/>
					<span class="error">*<?php errorMessage($errusername); ?></span>
                </td>
			</tr>
			<tr>
				<th><label for="email">Email:</label></th>
				<td><input type="email" name="email" id="email" size="50" class="form-control" placeholder="Required Email"
						   value="<?php if (isset($formdata['email'])) {
							   echo $formdata['email'];} ?>" required tabindex="2"/>
					<span class="error">*<?php errorMessage($erremail); ?></span>
                </td>
			</tr>
			<tr>
				<th><label for="email1">Confirmation Email:</label></th>
				<td><input type="email" name="email1" id="email1" size="50" class="form-control" placeholder="Required Confirmation Email"
						   required tabindex="3"/>
					<span class="error">*<?php errorMessage($erremail1); ?></span>
                </td>
			</tr>
			<tr>
				<th><label for="password">Password:</label></th>
				<td><input type="password" name="password" id="password" class="form-control" placeholder="Required Password" required tabindex="4"/>
                    <span class="error">*<?php errorMessage($errpassword); ?></span>
                </td>
			</tr>
			<tr>
				<th><label for="password1">Confirm Password:</label></th>
				<td><input type="password" name="password1" id="password1" class="form-control" placeholder="Required Confirmation Password"
						   required tabindex="5"/>
                    <span class="error">*<?php errorMessage($errpassword1); ?></span>
                </td>
			</tr>
			<tr>
				<th><label for="bio">What's your experience with the blockchain?</label></th>
				<td>
                    <span class="error">*<?php errorMessage($errbio); ?></span>
                    <textarea name="bio" id="bio" class="form-control" placeholder="Required Biography" required tabindex="6">
					<?php if (isset($formdata['bio'])) {echo $formdata['bio'];} ?>
				    </textarea>
				</td>
			</tr>
			<tr>
				<th><label for="submit">Submit:</label></th>
				<td><input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="7"/></td>
			</tr>
		</table>
	</form>
<?php
} // end showform
require_once "footer.inc.php";
?>
