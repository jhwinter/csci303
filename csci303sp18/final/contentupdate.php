<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:40
 */

$pagename = 'Update Content';
require_once "header.inc.php";
require_once "contentfunctions.php";

//set initial variables
$showform = True;
$iserror = False;
$errtitle = '';
$errcategory = '';
$errdetails = '';
$id = 0;
$userID = 0;
$result = array();
$categories = array(
	'BTC' => 'Bitcoin',
	'ETH' => 'Ethereum',
	'XRP' => 'Ripple',
	'BCH' => 'Bitcoin Cash',
	'LTC' => 'Litecoin',
	'ADA' => 'Cardano',
	'NEO' => 'NEO',
	'XLM' => 'Stellar Lumens',
	'EOS' => 'EOS',
	'XMR' => 'Monero'
);

require_once "authenticate.php";
require_once "verifyrequest.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$formdata = sanitizeData($_POST);

	if (isEmptyField($formdata['title'])){$iserror=True; $errtitle='Title is required.';}
	if (isEmptyField($formdata['category'])){$iserror=True; $errcategory='Category is required.';}
	if (isEmptyField($formdata['details'])){$iserror=True; $errdetails='Details are required.';}

	if (isMatchingField($formdata['title'], $formdata['origtitle']) == False)
	{
		if (isDuplicate($pdo, 'jtwintersContent', 'title', $formdata['title']))
		{
			$iserror = True;
			$errtitle = 'Title already exists in the database.';
		}
	}


	// control statement to handle errors
	if ($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
	{
		updateContentInDB($pdo, $formdata);
		$showform = False;
		echo "<p class='success'>Thanks for updating your information.</p>";
	}
}
if ($showform)
{
	$result = getContent($pdo, $id);
	?>
	<form name="updatecontent" id="updatecontent" method="post" action="contentupdate.php">
		<table class="table table-dark table-sm table-hover table-bordered">
			<tr>
				<th><label for="title">Title:</label></th>
				<td><input type="text" name="title" id="title" size="30" class="form-control" placeholder="Required Title"
						   value="<?php if (isset($formdata['title']) && !empty($formdata['title']))
						   {echo $formdata['title'];} else {echo $result['title'];} ?>" required autofocus tabindex="1"/>
					<span class="error">*<?php errorMessage($errtitle); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="category">Category:</label></th>
				<td>
					<select id="category" name="category" class="form-control" required autofocus tabindex="2">
						<option value="">Please select a Category</option>
						<?php foreach ($categories as $value)
						// problem with the logic:
							// since the $formdata and/or $result vars are set, then it never enters the else condition
						{
							if (isset($formdata['category']) && !empty($formdata['category']))
							{
								if (($formdata['category'] == $value)) // select what the user submitted
								{
									echo "<option value=" . $formdata['category'] . " selected>" . $formdata['category'] . "</option>\n";
								}
							}
							elseif ($result['category'] == $value) // select what's in the db
							{
								echo "<option value=" . $result['category'] . " selected>" . $result['category'] . "</option>\n";
							}
							else // display the value from the array
							{
								echo "<option value=" . $value . ">" . $value . "</option>\n";
							}
						} ?>
					</select>
					<span class="error">*<?php errorMessage($errcategory); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="details">Details:</label></th>
				<td>
                    <span class="error">*<?php errorMessage($errdetails); ?></span>
					<textarea name="details" id="details" placeholder="Required Details" class="form-control" required tabindex="3">
					<?php if (isset($formdata['details']) && !empty($formdata['details'])) {
						echo $formdata['details'];
					} else {
						echo $result['details'];} ?>
				</textarea>
				</td>
			</tr>
			<tr>
				<th><label for="submit">Submit:</label></th>
				<td>
					<input type="hidden" name="id" id="id" value="<?php echo $result['id']; ?>"/>
					<input type="hidden" name="origtitle" id="origtitle" value="<?php echo $result['title']; ?>"/>
					<input type="hidden" name="origcategory" id="origcategory" value="<?php echo $result['category']; ?>"/>
					<input type="hidden" name="origdetails" id="origdetails" value="<?php echo $result['details']; ?>"/>
					<input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>"/>
					<input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="4"/>
				</td>
			</tr>
		</table>
	</form>
	<?php
}
require_once "footer.inc.php";
?>