<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 3/13/2018
 * Time: 8:54 AM
 */
$pagename = "Example 9";
include_once "header.inc.php";

//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errmsg = 0;
$errfname = "";
$errlname = "";
$erruname = "";
$erremail = "";
$errpwd = "";
$errpwd2 = "";
$errgender = "";
$errclassyr = "";
$errbio = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    /* ***********************************************************************
     * SANITIZE USER DATA
     * Use strtolower()  for emails, usernames and other case-sensitive info
     * Use trim() for ALL user-typed data -- even those not required
     * CAUTION:  Radio buttons are a bit different.
     *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
     * ***********************************************************************
     */
    $formdata['fname'] = trim($_POST['fname']);
    $formdata['mi'] = trim($_POST['mi']);
    $formdata['lname'] = trim($_POST['lname']);
    $formdata['uname'] = trim(strtolower($_POST['uname']));
    $formdata['email'] = trim(strtolower($_POST['email']));
    $formdata['pwd'] = trim($_POST['pwd']);
    $formdata['pwd2'] = trim($_POST['pwd2']);
    if(isset($_POST['gender'])){$formdata['gender'] = $_POST['gender'];}
    $formdata['classyr'] = $_POST['classyr'];
    $formdata['bio'] = trim($_POST['bio']);


    /* ***********************************************************************
     * CHECK EMPTY FIELDS
     * Check for empty data for every required field
     * Do not do for things like apartment number, middle initial, etc.
     * CAUTION:  Radio buttons with 0 as a value = use isset() not empty()
     *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
     * ***********************************************************************
     */
    if (empty($formdata['fname'])) {
        $errfname = "The first name is required.";
        $errmsg = 1;
    }
    if (empty($formdata['lname'])) {$errlname = "The last name is required."; $errmsg = 1; }
    if (empty($formdata['uname'])) {$erruname = "The username is required."; $errmsg = 1; }
    if (empty($formdata['email'])) {$erremail = "The email is required."; $errmsg = 1; }
    if (empty($formdata['pwd'])) {$errpwd = "The password is required."; $errmsg = 1; }
    if (empty($formdata['pwd2'])) {$errpwd2 = "The confirmation password is required."; $errmsg = 1; }
    if (isset($formdata['gender'])) {$errgender = "The gender is required."; $errmsg = 1; }
    if (empty($formdata['classyr'])) {$errclassyr = "The class year is required."; $errmsg = 1; }
    if (empty($formdata['bio'])) {$errbio = "The biography is required."; $errmsg = 1; }

    /* ***********************************************************************
     * CHECK MATCHING FIELDS
     * Check to see if important fields match
     * Usually used for passwords and sometimes emails.  We'll do passwords.
     * ***********************************************************************
     */
    if($formdata['pwd'] != $formdata['pwd2'])
    {
        $errmsg = 1;
        $errpwd2 = "The passwords do not match.";
    }

    /* ***********************************************************************
     * CHECK EXISTING DATA
     * Check data to avoid duplicates
     * Usually used with emails and usernames - We'll do usernames
     * ***********************************************************************
     */
    try
    {
        $sql = "SELECT * FROM Customers WHERE uname = :uname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uname', $formdata['uname']);
        $stmt->execute();
        $countuname = $stmt->rowCount();
        if ($countuname > 0)
        {
            $errmsg = 1;
            $erruname = "Username already taken.";
        }
    }
    catch (PDOException $e)
    {
        echo "<p class='error'>Error checking duplicate users!" . $e->getMessage() . "</p>";
        exit();
    }

    /* ***********************************************************************
     * CONTROL STATEMENT TO HANDLE ERRORS
     * ***********************************************************************
     */
    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{

        /* ***********************************************************************
         * HASH SENSITIVE DATA
         * Used for passwords and other sensitive data
         * If checked for matching fields, do NOT hash and insert both to the DB
         * ***********************************************************************
         */
        $hashedpwd = password_hash($formdata['pwd'], PASSWORD_BCRYPT);

        /* ***********************************************************************
         * INSERT INTO THE DATABASE
         * NOT ALL data comes from the form - Watch for this!
         *    For example, input dates are not entered from the form
         * ***********************************************************************
         */

        try{
            $sql = "INSERT INTO Customers (fname, mi, lname, uname, email, pwd, gender, classyr, inputdate) 
                    VALUES (:fname, :mi, :lname, :uname, :email, :pwd, :gender, :classyr, :InputDate) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':fname', $formdata['fname']);
            $stmt->bindValue(':mi', $formdata['mi']);
            $stmt->bindValue(':lname', $formdata['lname']);
            $stmt->bindValue(':uname', $formdata['uname']);
            $stmt->bindValue(':email', $formdata['email']);
            $stmt->bindValue(':pwd', $hashedpwd);
            $stmt->bindValue(':gender', $formdata['gender']);
            $stmt->bindValue(':classyr', $formdata['classyr']);
            $stmt->bindValue(':InputDate', $rightnow);
            $stmt->execute();

            $showform =0; //hide the form
            echo "<p class='success'>Thanks for entering your information.</p>";
        }
        catch (PDOException $e)
        {
            die( $e->getMessage() );
        }
    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
?>
    <form name="addcustomers" id="addcustomers" method="post" action="example9.php">
        <table>
            <tr><th><label for="fname">First Name:</label></th>
                <td><input name="fname" id="fname" type="text" size="20" placeholder="Required First Name"
                           value="<?php if(isset($formdata['fname'])){echo $formdata['fname'];}?>"/>
                    <span class="error">*<?php if(isset($errfname)){echo $errfname;}?></span></td>
            </tr>
            <tr><th><label for="mi">Middle Initial:</label></th>
                <td><input type="text" name="mi" id="mi" size="10" maxlength="1" placeholder="Optional"
                           value="<?php if(isset($formdata['mi'])){echo $formdata['mi'];}?>"/>
                </td>
            </tr>
            <tr><th><label for="lname">Last Name:</label></th>
                <td><input type="text" name="lname" id="lname" size="30" placeholder="Required Last Name"
                           value="<?php if(isset($formdata['lname'])){echo $formdata['lname'];}?>"/>
                    <span class="error">*<?php if(isset($errlname)){echo $errlname;}?></span></td>
            </tr>
            <tr><th><label for="uname">Username:</label></th>
                <td><input type="text" name="uname" id="uname" size="30" placeholder="Required Username"
                           value="<?php if(isset($formdata['uname'])){echo $formdata['uname'];}?>"/>
                    <span class="error">*<?php if(isset($erruname)){echo $erruname;}?></span></td>
            </tr>
            <tr><th><label for="email">Email:</label></th>
                <td><input type="email" name="email" id="email" size="50" placeholder="Required Email"
                           value="<?php if(isset($formdata['email'])){echo $formdata['email'];}?>"/>
                    <span class="error">*<?php if(isset($erremail)){echo $erremail;}?></span></td>
            </tr>
            <tr><th><label for="pwd">Password:</label></th>
                <td><input type="password" name="pwd" id="pwd" size="45" placeholder="Required Password" />
                    <span class="error">*<?php if(isset($errpwd)){echo $errpwd;}?></span></td>
            </tr>
            <tr><th><label for="pwd2">Confirm Password:</label></th>
                <td><input type="password" name="pwd2" id="pwd2" size="45" placeholder="Required Password Again" />
                    <span class="error">*<?php if(isset($errpwd2)){echo $errpwd2;}?></span></td>
            </tr>
            <tr><th>Gender:</label></th>
                <td><input type="radio" name="gender" id="gender-f" value="f"
                        <?php if(isset($formdata['gender']) && $formdata['gender']=="f"){echo " checked";}?>
                    />
                    <label for="gender-f">Female</label>
                    <br/>
                    <input type="radio" name="gender" id="gender-m" value="m"
                        <?php if(isset($formdata['gender']) && $formdata['gender']=="m"){echo " checked";}?>
                    /><label for="gender-m">Male</label>
                    <span class="error">*<?php if(isset($errgender)){echo $errgender;}?></span></td>
            </tr>
            <tr><th>Class Year:</label></th>
                <td><select name="classyr" id="classyr">
                        <option value="" <?php if(isset($formdata['classyr']) && $formdata['classyr']==""){echo " selected";}?>>SELECT ONE</option>
                        <option value="Freshman" <?php if(isset($formdata['classyr']) && $formdata['classyr']=="Freshman"){echo " selected";}?>>Freshman</option>
                        <option value="Sophomore" <?php if(isset($formdata['classyr']) && $formdata['classyr']=="Sophomore"){echo " selected";}?>>Sophomore</option>
                        <option value="Junior" <?php if(isset($formdata['classyr']) && $formdata['classyr']=="Junior"){echo " selected";}?>>Junior</option>
                        <option value="Senior" <?php if(isset($formdata['classyr']) && $formdata['classyr']=="Senior"){echo " selected";}?>>Senior</option>
                    </select>
                    <span class="error">* <?php if(isset($errclassyr)){echo $errclassyr;}?></span></td>
            </tr>
            <tr><th><label for="bio">Biography:</label></th>
                <td><span class="error">* <?php if(isset($errbio)){echo $errbio;}?></span>
                    <textarea name="bio" id="bio" placeholder="Required Biography"><?php if(isset($formdata['bio'])){echo $formdata['bio'];}?></textarea>
                </td>
            </tr>
            <tr><th><label for="submit">Submit:</label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>
        </table>
    </form>
<?php
}//end showform
include_once "footer.inc.php";
?>








