<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/03/20
 * Time: 11:19
 */

$pagename ="Simple Insert";
require_once "header.inc.php";
//set initial variables
$showform = 1;  // show form is true
$errormsg = 0;
$erroremail = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$formdata['email'] = trim(strtolower($_POST['email']));

	//check for empty fields
	if (empty($formdata['email'])) {
		$erroremail = "The email field is required.";
		$errormsg = 1;
	}
	/*check matching
	if($formdata['pwd'] != $formdata['pwd2'])
	{
		$errormsg = 1;
		echo "<p class='error'>The passwords do not match</p>";
	}
	*/
	//check existing entries
	try
	{
		$sql = "SELECT * FROM Members WHERE email = :email";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':email', $formdata['email']);
		$stmt->execute();
		$countemail = $stmt->rowCount();
		if ($countemail > 0)
		{
			$errormsg = 1;
			$erroremail = "<p>Email already taken.</p>";
		}
	}
	catch (PDOException $e)
	{
		echo "<p class='error'>Error getting members!" . $e->getMessage() . "</p>";
		exit();
	}

	//control statement for flow of program after error checking
	if($errormsg == 1)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
    {
		//since we can proceed, hash the secure item (can be done earlier as well)
		// $hashedblah = password_hash($formdata['blah'], PASSWORD_BCRYPT);
		try
        {
			//query the data
			$sql = "INSERT INTO Members (email) VALUES (:email) ";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $formdata['email']);
			$stmt->execute();

			//hide the form
			$showform =0;
			echo "<p>Thanks for entering your information.</p>";
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
<form name="addmembers" id="addmembers" method="post" action="simpleinsert.php">

	<table>
		<tr><th><label for="email">Email: </label></th>
			<td><input name="email" id="email" type="email" placeholder="Required Email"
					   value="<?php
					   if(isset($formdata['email']))
					   {
						   echo $formdata['email'];
					   }
					   ?>"
				/>
                <span class="error">* <?php if(isset($erroremail)){echo $erroremail;}?></span></td>
		</tr>
		<tr><th><label for="submit">Submit: </label></th>
			<td><input type="submit" name="submit" id="submit" value="submit"/></td>
		</tr>
	</table>
	<?php
}//end showform
include_once "footer.inc.php";
?>
