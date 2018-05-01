<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 3/13/2018
 * Time: 8:54 AM
 */

$pagename ="Simple Form";
include_once "header.inc.php";

//set initial variables
$showform = 1;  // show form is true
$errormsg = 0;
$erroremail = "";
$erroremail2 = "";

$errorusername = "";
$errorpassword = "";
$errorpassword2 = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    /* ***********************************************************************
     * SANITIZE USER DATA
     * Use strtolower()  for emails, usernames and other case-sensitive info
     * Use trim() for ALL user-typed data
     * ***********************************************************************
     */
    $formdata['email'] = trim(strtolower($_POST['email']));
    $formdata['email2'] = trim(strtolower($_POST['email2']));

    $formdata['username'] = trim(strtolower($_POST['username']));
    $formdata['password'] = trim($_POST['password']);
    $formdata['password2'] = trim($_POST['password2']);

    /* ***********************************************************************
     * CHECK EMPTY FIELDS
     * Check for empty data for every required field
     * Do not do for things like apartment number, middle initial, etc.
     * ***********************************************************************
     */
        if (empty($formdata['email'])) {
            $erroremail = "The email field is required.";
            $errormsg = 1;
        }
        if (empty($formdata['email2'])) {
            $erroremail2 = "The confirmation email field is required.";
            $errormsg = 1;
        }

        if (empty($formdata['username'])) {
            $errorusername = "The username field is required.";
            $errormsg = 1;
        }
        if (empty($formdata['password'])) {
            $errorpassword = "The password field is required.";
            $errormsg = 1;
        }
        if (empty($formdata['password2'])) {
            $errorpassword2 = "The confirmation password field is required.";
            $errormsg = 1;
        }

    /* ***********************************************************************
     * CHECK MATCHING FIELDS
     * Used for important fields that need confirmation
     * Usually seen with emails or passwords.
     * ***********************************************************************
     */
    if($formdata['email'] != $formdata['email2'])
    {
        $errormsg = 1;
        echo "<p class='error'>The emails do not match.</p>";
        $erroremail2 = "<span class='error'>Emails must match.</span>";
    }

    if($formdata['password'] != $formdata['password2'])
    {
        $errormsg = 1;
        echo "<p class='error'>The passwords do not match.</p>";
        $errorpassword2 = "<span class='error'>Passwords must match.</span>";
    }

    /* ***********************************************************************
     * CHECK EXISTING ENTRIES
     * Used if you cannot have duplicate entries in a database
     * Usually seen for emails and usernames
     *
     * CODE WILL BE ADDED LATER!!!!
     * ***********************************************************************
     *
     *
      ***********************************************************************
     * CONTROL OF PROGRAM AFTER ERROR CHECKING
     * Handles what we do with errors and without
     * ***********************************************************************
     */
    if($errormsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{
        $hashedpassword = password_hash($formdata['password'], PASSWORD_BCRYPT);
        /* ***********************************************************************
         * HASH PASSWORDS
         *
         * INSERT INTO DATABASE
         *
         * CODE WILL BE ADDED LATER!!!!
         * ************************************************************************
        */

        echo "<p class='success'>Thank you for entering your data!</p>";
        $showform = 0;

    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
?>
    <form name="simpleform" id="simpleform" method="post" action="simpleform.php">

        <table>
            <tr><th><label for="email">Email:</label></th>
                <td><input name="email" id="email" type="email" size="40" placeholder="*required email"
                           value="<?php if(isset($formdata['email'])){echo $formdata['email'];}?>"
                    /><span class="error"><?php if(isset($erroremail)){echo $erroremail;}?></span></td>
            </tr>
            <tr><th><label for="email2">Confirm Email:</label></th>
                <td><input name="email2" id="email2" type="email" size="40" placeholder="*required email confirmation"
                           value="<?php if(isset($formdata['email2'])){echo $formdata['email2'];}?>"
                    /><span class="error"><?php if(isset($erroremail2)){echo $erroremail2;}?></span></td>
            </tr>
            <tr><th><label for="username">Username:</label></th>
                <td><input name="username" id="username" type="text" size="40" placeholder="*required username"
                           value="<?php if(isset($formdata['username'])){echo $formdata['username'];}?>"
                    /><span class="error"><?php if(isset($errorusername)){echo $errorusername;}?></span></td>
            </tr>
            <tr><th><label for="password">Password:</label></th>
                <td><input name="password" id="password" type="password" size="40" placeholder="*required password"
                    /><span class="error"><?php if(isset($errorpassword)){  $errorpassword;}?></span></td>
            </tr>
            <tr><th><label for="password">Confirm Password:</label></th>
                <td><input name="password2" id="password2" type="password" size="40" placeholder="*required password confirmation" />
                    <span class="error"><?php if(isset($errorpassword2)){echo $errorpassword2;}?></span></td>
            </tr>
            <tr><th><label for="submit">Submit: </label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>
        </table>
    </form>
<?php
}//end showform
include_once "footer.inc.php";
?>