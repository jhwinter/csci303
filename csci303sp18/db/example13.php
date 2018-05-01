<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/10
 * Time: 11:48
 */

$pagename = "Example 13";
include_once "header.inc.php";

//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errormsg = 0;
$errorname = '';
$errordesc = '';
$namedupcounter = 0; // counting number of duplicate category names
$descdupcounter = 0; // counting number of duplicate descriptions
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
//PROCESS CODE UPON SUBMIT
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

	/* ***********************************************************************
	 * CHECK EXISTING DATA
	 * Check data to avoid duplicates
	 * Usually used with emails and usernames - We'll do usernames
	 *
	 * ONLY CHECK FOR DUPLICATES IF THE VALUE BEING CHECKED CHANGES!!!
	 *      -- WE ADD AN IF STATEMENT FIRST
	 * ***********************************************************************
	 */
    if ($formdata['catname'] != $_POST['origname'])
    {
        try
        {
            // convert category name and description to all uppercase
            $catnameupper = strtoupper($formdata['catname']);

            // get all category names and descriptions from database
            $sql = "SELECT CategoryName FROM Categories";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // check every category name and description to see if it already exists in db
            // if it does increase the respective counter
            foreach ($result as $row)
            {
                // convert category name and description's to all uppercase
                $categorynameupper = strtoupper($row['CategoryName']);

                // compare the category name/description from the db to the one entered by the user
                // if a duplicate is found, increase the respective counter
                if ($categorynameupper == $catnameupper)
                {
                    $namedupcounter += 1;
                }
            }

            // if duplicate counter for name/description is greater than 0,
            // set errormsg to 1 and inform the user the name/description already exists.
            if ($namedupcounter > 0)
            {
                $errormsg = 1;
                $errorname = 'Category Name already exists.';
            }
        }
        catch (PDOException $e)
        {
            echo "<p class='error'>Error checking duplicate names!" . $e->getMessage() . "</p>";
            exit();
        }
    } // closing if not original
    if ($formdata['catdesc'] != $_POST['origdesc'])
    {
        try
        {
            // convert category name and description to all uppercase
            $catdescupper = strtoupper($formdata['catdesc']);

            // get all category names and descriptions from database
            $sql = "SELECT Description FROM Categories";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // check every category name and description to see if it already exists in db
            // if it does increase the respective counter
            foreach ($result as $row)
            {
                // convert category name and description's to all uppercase
                $categorydescupper = strtoupper($row['Description']);

                // compare the category name/description from the db to the one entered by the user
                // if a duplicate is found, increase the respective counter
                if ($categorydescupper == $catdescupper)
                {
                    $descdupcounter += 1;
                }
            }

            // if duplicate counter for name/description is greater than 0,
            // set errormsg to 1 and inform the user the name/description already exists.
            if ($descdupcounter > 0)
            {
                $errormsg = 1;
                $errordesc = 'Description already exists.';
            }
        }
        catch (PDOException $e)
        {
            echo "<p class='error'>Error checking duplicate descriptions!" . $e->getMessage() . "</p>";
            exit();
        }
    } // closing if not original
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
			$sql = "UPDATE Categories 
                    SET CategoryName = :catname, Description = :catdesc 
                    WHERE ID = :ID";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':catname', $formdata['catname']);
			$stmt->bindValue(':catdesc', $formdata['catdesc']);
			$stmt->bindValue(':ID', $id); // NOTICE THIS IS THE VAR WE CREATED
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
    $stmt->bindValue(':ID', $id); // NOTICE THIS IS THE VAR WE CREATED
    $stmt->execute();
    $row = $stmt->fetch();
	?>
    <form name="updatecategory" id="updatecategory" method="post" action="example13.php">
        <table>
            <tr>
                <th><label for="catname">Category Name:</label></th>
                <td>
                    <input type="text" name="catname" id="catname" placeholder="Required Category name" value="<?php
                    if (isset($formdata['catname']) && !empty($formdata['catname']))
                    {
                        echo $formdata['catname'];
                    }
                    else
                    {
                        echo $row['CategoryName'];
                    }
                    ?>"/>
                    <span class="error">* <?php if(isset($errorname)){echo $errorname;} ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="catdesc">Description:</label></th>
                <td>
                    <span class="error">* <?php if(isset($errordesc)){echo $errordesc;} ?></span>
                    <textarea name="catdesc" id="catdesc" placeholder="Required Category description">
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
                    <input type="hidden" id="ID" name="ID" value="<?php echo $row['ID']; ?>"/>
                    <input type="hidden" id="origname" name="origname" value="<?php echo $row['CategoryName']; ?>"/>
                    <input type="hidden" id="origdesc" name="origdesc" value="<?php echo $row['Description']; ?>"/>
                    <input type="submit" name="submit" id="submit" value="submit"/>
                </td>
            </tr>
        </table>
    </form>
	<?php
}//end showform
include_once "footer.inc.php";
?>








