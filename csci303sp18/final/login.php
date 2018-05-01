<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/19
 * Time: 15:53
 */

$pagename = "Login";  // pagename var is used in the header
require_once "header.inc.php";
require_once "userfunctions.php";

//SET INITIAL VARIABLES
$showform = True;
$iserror = False;
$errorusername = '';
$errorpassword = '';
$formdata = array();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$formdata = sanitizeData($_POST);

	if (isEmptyField($formdata['username']))
	{
		$iserror = True;
		$errusername = 'Username is required.';
	}
	if (isEmptyField($formdata['password']))
	{
		$iserror = True;
		$errpassword = 'Password is required.';
	}

	if($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
    {
		$result = verifyUser($pdo, $formdata['username'], $formdata['password']);
		if ($result != False)
        {
            $_SESSION['id'] = $result['id'];
            echo 'session id: ' . $_SESSION['id'];
            $_SESSION['username'] = $result['username'];
            $showform = False;
            header("Location: confirm.php?state=2");
        }
        else
        {
			echo "<p class='error'>The username and password combination you entered is not correct.  Please try again.</p>";
		}
	} // else errormsg
}//submit
if($showform == True){
?>
	<form name="login" id="login" method="POST" action="login.php">
        <table class="table table-dark table-sm table-hover table-bordered">
            <tr><th><label for="username">Username: </label></th>
                <td><input name="username" id="username" type="text" class="form-control" placeholder="Required Username"
                           value="<?php if(isset($formdata['username']))
                           {echo $formdata['username'];}?>" autofocus required tabindex="1"/>
                    <span class="error">* <?php if(isset($errorusername)){echo $errorusername;} ?></span>
                </td>
            </tr>
            <tr><th><label for="password">Password: </label></th>
                <td><input name="password" id="password" type="password" class="form-control" placeholder="Required Password"
                           value="<?php if(isset($formdata['password']))
                           {echo $formdata['password'];}?>" required tabindex="2"/>
                    <span class="error">*<?php if(isset($errpassword)){echo $errpassword;} ?></span>
                </td>
            </tr>
            <tr><th><label for="submit">Submit: </label></th>
                <td><input type="submit" name="submit" id="submit" value="submit" class="button btn btn-success" tabindex="3"/></td>
            </tr>
        </table>
    </form>

<?php
}//end showform
require_once "footer.inc.php";
?>