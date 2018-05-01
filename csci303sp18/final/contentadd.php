<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/04/21
 * Time: 20:40
 */

$pagename = 'Add Content';
require_once "header.inc.php";
require_once "contentfunctions.php";

// SET INITIAL VARIABLES
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
$showform = True;
$iserror = False;
$formdata = array();
$errtitle = '';
$errcategory = '';
$errdetails = '';
$userID = 0;

require_once "authenticate.php";

// Process code upon submit
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$formdata = sanitizeData($_POST); // sanitize user data

	// check for empty fields
	if (isEmptyField($formdata['title'])) {$iserror = True; $errtitle = 'Title is required.';}
	if (isEmptyField($formdata['category'])) {$iserror = True; $errcategory = 'Category is required';}
	if (isEmptyField($formdata['details'])) {$iserror = True; $errdetails = 'Details are required.';}

	// check for duplicate usernames/emails
	if (isDuplicate($pdo, 'jtwintersContent', 'title', $formdata['title']) && (isEmptyField($formdata['title'] == False)))
	{
		$iserror = True;
		$errtitle = 'Title already exists.';
	}

	// control statement to handle errors
	if ($iserror)
	{
		echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
	}
	else
	{
		if(insertContentInDB($pdo, $formdata, $userID, $rightnow))
		{
			$showform = False;
			echo "<p class='success'>Thanks for entering your information.</p>";
		}
	} // end of else control statement
} // end of if request method is post
if ($showform)
{
?>
<form name="addcontent" id="addcontent" method="post" action="contentadd.php">
    <table class="table table-dark table-sm table-hover table-bordered">
		<tr>
			<th><label for="title">Title:</label></th>
			<td><input type="text" name="title" id="title" size="30" class="form-control" placeholder="Required Title"
					   value="<?php if (isset($formdata['title'])) {
						   echo $formdata['title'];} ?>" required autofocus tabindex="1"/>
				<span class="error">*<?php errorMessage($errtitle); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="category">Category:</label></th>
			<td>
				<select id="category" name="category" class="form-control" required tabindex="2">
					<option value="" selected>Please select a Category</option>
					<?php foreach ($categories as $value)
					{
						if (isset($formdata['category']) && ($formdata['category'] == $value))
						{
							echo "<option value=" . $value . " selected>" . $value . "</option>\n";
						}
						else
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
					<?php if (isset($formdata['details'])) {echo $formdata['details'];} ?>
				</textarea>
			</td>
		</tr>
		<tr>
			<th><label for="submit">Submit:</label></th>
			<td>
                <input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>"/>
                <input type="submit" name="submit" id="submit" value="submit" class="btn btn-success" tabindex="4"/>
            </td>
		</tr>
	</table>
</form>
<?php
} // end showform
require_once "footer.inc.php";
?>