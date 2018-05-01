<?php
/**
 * Created by PhpStorm.
 * User: YOUR USERNAME
 * Date: CURRENT DATE
 * Time: CURRENT TIME
 */
$pagename = "Example 10";
include_once "header.inc.php";

//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errormsg = 0;
$errorname = '';
$errordesc = '';
$namedupcounter = 0; // counting number of duplicate category names
$descdupcounter = 0; // counting number of duplicate descriptions
//continue with necessary fields

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
    $formdata['catname'] = trim($_POST['catname']);
    $formdata['catdesc'] = trim($_POST['catdesc']);

    /* ***********************************************************************
     * CHECK EMPTY FIELDS
     * Check for empty data for every required field
     * Do not do for things like apartment number, middle initial, etc.
     * CAUTION:  Radio buttons with 0 as a value = use isset() not empty()
     *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
     * ***********************************************************************
     */
    //CODE GOES HERE
    if (empty($formdata['catname']))
    {
        $errorname = 'The category name is required.';
        $errormsg = 1;
    }
    if (empty($formdata['catdesc']))
    {
        $errordesc = 'A description for the category is required.';
        $errormsg = 1;
    }

    /* ***********************************************************************
     * CHECK MATCHING FIELDS
     * Check to see if important fields match
     * Usually used for passwords and sometimes emails.  We'll do passwords.
     * ***********************************************************************
     */
    //CODE GOES HERE
    // No passwords or emails entered here

    /* ***********************************************************************
     * CHECK EXISTING DATA
     * Check data to avoid duplicates
     * Usually used with emails and usernames - We'll do usernames
     * ***********************************************************************
     */
    try
    {
        // convert category name and description to all uppercase
        $catnameupper = strtoupper($formdata['catname']);
        $catdescupper = strtoupper($formdata['catdesc']);

        // get all category names and descriptions from database
        $sql = "SELECT CategoryName, Description 
                FROM Categories";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // check every category name and description to see if it already exists in db
        // if it does increase the respective counter
        foreach ($result as $row)
        {
            // convert category name and description's to all uppercase
            $categorynameupper = strtoupper($row['CategoryName']);
			$categorydescupper = strtoupper($row['Description']);

			// compare the category name/description from the db to the one entered by the user
            // if a duplicate is found, increase the respective counter
			if ($categorynameupper == $catnameupper)
            {
                $namedupcounter += 1;
            }
            if ($categorydescupper == $catdescupper)
            {
                $descdupcounter += 1;
            }
        }

        // if duplicate counter for name/description is greater than 0,
        // set errormsg to 1 and inform the user the name/description already exists.
        if ($namedupcounter > 0)
        {
            $errormsg = 1;
            $errorname = 'Category Name already exists.';
        }
        if ($descdupcounter > 0)
        {
            $errormsg = 1;
            $errordesc = 'Description already exists.';
        }

    }
    catch (PDOException $e)
    {
        echo "<p class='error'>Error checking duplicate names/descriptions!" . $e->getMessage() . "</p>";
        exit();
    }

    /* ***********************************************************************
     * CONTROL STATEMENT TO HANDLE ERRORS
     * ***********************************************************************
     */
    if($errormsg == 1)
    {
        echo "<p class='error'>There are errors. Please make corrections and resubmit.</p>";
    }
    else
    {

        /* ***********************************************************************
         * HASH SENSITIVE DATA
         * Used for passwords and other sensitive data
         * If checked for matching fields, do NOT hash and insert both to the DB
         * ***********************************************************************
         */
        // NOT NEEDED

        /* ***********************************************************************
         * INSERT INTO THE DATABASE
         * NOT ALL data comes from the form - Watch for this!
         *    For example, input dates are not entered from the form
         * ***********************************************************************
         */
        try
        {
        $sql = "INSERT INTO Categories (CategoryName, Description, InputDate)
                VALUES (:catname, :catdesc, :inputdate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':catname', $formdata['catname']);
        $stmt->bindValue(':catdesc', $formdata['catdesc']);
        $stmt->bindValue(':inputdate', $rightnow);
        $stmt->execute();

        $showform = 0; // hide the form
        echo "<p class='success'>Thanks for entering a new category.</p>";
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
?>
<form name="addcategories" id="addcategories" method="post" action="example10.php">
    <table>
        <tr>
            <th><label for="catname">Category Name:</label></th>
            <td>
                <input type="text" name="catname" id="catname" placeholder="Required Category name"/>
                <span class="error">* <?php if(isset($errorname)){echo $errorname;} ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="catdesc">Description:</label></th>
            <td>
                <span class="error">* <?php if(isset($errordesc)){echo $errordesc;} ?></span>
                <textarea name="catdesc" id="catdesc" placeholder="Required Category description">
                    <?php if(isset($formdata['catdesc'])){echo$formdata['catdesc'];} ?>
                </textarea>
            </td>
        </tr>
        <tr>
            <th><label for="submit">Submit:</label></th>
            <td><input type="submit" name="submit" id="submit" value="submit"/></td>
        </tr>
    </table>
</form>
<?php
}//end showform
include_once "footer.inc.php";
?>








