<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/10
 * Time: 11:48
 */

$pagename = "Example 12";
include_once "header.inc.php";

//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errormsg = 0;
$errordesc = '';
$id = 0;
//continue with necessary fields

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']))
{
    $id = $_GET['ID'];
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ID']))
{
    $id = $_POST['ID'];
}
else
{
    echo "<p class='error'>Something happened! Cannot obtain the correct entry.</p>";
    $errormsg = 1;
}

// PROCESS CODE UPON SUBMIT
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

	/* ***********************************************************************
	 * CONTROL STATEMENT TO HANDLE ERRORS
	 * ***********************************************************************
	 */
	if($errormsg == 1)
	{
		echo "<p class='error'>There are errors. Please make corrections and resubmit. Repopulating required empty fields with original values. </p>";
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
		    $sql = "UPDATE Categories 
                    SET Description = :catdesc 
                    WHERE ID = :ID ";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':catdesc', $formdata['catdesc']);
			$stmt->bindValue(':ID', $id);
			$stmt->execute();

			$showform = 0; // hide the form
			echo "<p class='success'>Thanks for UPDATING your information.</p>";
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
    // COLLECT ORIGINAL DATA TO POPULATE FORM
    $sql = "SELECT * FROM Categories WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $id); // VARIABLE WE CREATED
    $stmt->execute();
    $row = $stmt->fetch();
	?>
    <form name="updatecategory" id="updatecategory" method="post" action="example12.php">
        <table>
            <tr>
                <th><label for="catdesc">Description:</label></th>
                <td>
                    <span class="error">* <?php if(isset($errordesc)){echo $errordesc;} ?></span>
                    <textarea name="catdesc" id="catdesc" placeholder="Required Category Description">
                    <?php
                    if (isset($formdata['catdesc']) && !empty($formdata['catdesc']))
                    {
                        echo $formdata['catdesc'];
                    }
                    else
                    {
                        echo $row['Description'];
                    }
                    ?>
                </textarea>
                </td>
            </tr>
            <tr>
                <th><label for="submit">Submit:</label></th>
                <td>
                    <input type="hidden" name="ID" id="ID" value="<?php echo $row['ID']; ?>"/>
                    <input type="submit" name="submit" id="submit" value="submit"/>
                </td>
            </tr>
        </table>
    </form>
	<?php
}//end showform
include_once "footer.inc.php";
?>








