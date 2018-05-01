<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/19
 * Time: 16:57
 */



/**
 * function that determines how to show specific links to the user (for nav page)
 * @param $currentfile 	the file that the user is currently viewing
 * @param $afile 		the file name of the file that is being checked against $currentfile
 * @param $listlink 	the text that will displayed between the li tags in the html
 */
function showIfLoggedIn($currentfile, $afile, $listlink)
{
	if (isset($_SESSION['username']))
	{
		if ($currentfile == $afile)
		{
			echo "<li class='nav-item'>$listlink</li>";
		}
		else
		{
			echo "<li class='nav-item'><a href=" . $afile . " class='nav-link'>$listlink</a></li>";
		}
	}
}

/**
 * @param $currentfile
 * @param $afile
 * @param $listlink
 */
function showIfNotLoggedIn($currentfile, $afile, $listlink)
{
	if (isset($_SESSION['username']) == False)
	{
		if ($currentfile == $afile)
		{
			echo "<li class='nav-item'>$listlink</li>";
		}
		else
		{
			echo "<li class='nav-item'><a href=" . $afile . " class='nav-link'>$listlink</a></li>\n";
		}
	}
}

/**
 * @param $pdo
 * @param $userid
 * @param $contentid
 * @return bool
 */
function verifyUserPrivilege($pdo, $userid, $contentid)
{
	if (empty($contentid))
	{
		$result = getUser($pdo, $userid);
		if ($result['id'] != $userid)
		{
			echo "<p class='error'>You do not have permission to view this page.</p>";
			return False;
		}
	}
	elseif (!empty($contentid))
	{
		$result = getContent($pdo, $contentid);
		if ($result['userID'] != $userid)
		{
			echo "<p class='error'>You do not have permission to view this page.</p>";
			return False;
		}
	}
	else
	{
		return True;
	}
}

/**
 * @param $errormessage
 * @return bool
 */
function errorMessage($errormessage)
{
	if (isset($errormessage))
	{
		echo $errormessage;
	}
	else
	{
		return False;
	}
}

/**
 * SANITIZE USER DATA
 * Use strtolower()  for emails, usernames and other case-sensitive info
 * Use trim() for ALL user-typed data -- even those not required
 * CAUTION:  Radio buttons are a bit different.
 *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
 * @param $post
 * @return mixed
 */
function sanitizeData($post)
{
	$formdata = array();
	foreach ($post as $key => $val)
	{
		if (($key == 'username') || ($key == 'email') || ($key == 'email1'))
		{
			$post[$key] = strtolower($post[$key]);
		}
		$formdata[$key] = trim($post[$key]);
	}
	return $formdata;
}


/**
 * CHECK EMPTY FIELDS
 * Check for empty data for every required field
 * Do not do for things like apartment number, middle initial, etc.
 * CAUTION:  Radio buttons with 0 as a value = use isset() not empty()
 *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
 * @param $formdata
 * @return mixed
 */
function isEmptyField($field)
{
	if (empty($field))
	{
		return True;
	}
	else
	{
		return False;
	}
}

/**
 * CHECK MATCHING FIELDS
 * Check to see if important fields match
 * Usually used for passwords and sometimes emails.
 * @param $field
 * @param $field1
 * @return bool
 */
function isMatchingField($field, $field1)
{
	if ($field != $field1)
	{
		return False;
	}
	else
	{
		return True;
	}
}

/**
 * CHECK EXISTING DATA
 * Check data to avoid duplicates
 * Usually used with emails and usernames
 * @param $pdo
 * @param $possduplicate
 * @return bool
 */
function isDuplicate($pdo, $table, $column, $possduplicate)
{
	try
	{
		if (!empty($table) && !empty($column) && !empty($possduplicate))
		{
			$sql = "SELECT * FROM $table WHERE $column = :$column";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue($column, $possduplicate);
			$stmt->execute();
			$result = $stmt->rowCount();
			if ($result > 0)
			{
				return True;
			}
		}
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}
?>