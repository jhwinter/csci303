<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/24
 * Time: 00:55
 */



/**
 * @param $pdo 		database connection
 * @return mixed 	returns an associative array of user's ids and usernames
 */
function getAllUsers($pdo)
{
	try
	{
		$sql = "SELECT id, username FROM jhwinterUser ORDER BY username";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * @param $pdo
 * @param $id
 * @return mixed
 */
function getUser($pdo, $id)
{
	try
	{
		$sql = "SELECT * FROM jhwinterUser WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * CHECK USER AND VERIFY PASSWORD
 * First, check to see if the username submitted exists
 *   - if no, notify user
 *   - if yes, verify password and redirect to confirmation page upon success.
 * @param $pdo
 * @param $username
 * @param $password
 * @return bool
 */
function verifyUser($pdo, $username, $password)
{
	try
	{
		$sql = "SELECT id, username FROM jhwinterUser WHERE username = :username";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		$result = $stmt->fetch();
		$usercount = $stmt->rowCount();
		if ($usercount < 1)
		{
			echo "<p class='error'>This user cannot be found.</p>";
			return False;
		}
		else
		{
			if (verifyPassword($pdo, $password, $username))
			{
				return $result;
			}
			else
			{
				return False;
			}
		}
	}
	catch (PDOException $e)
	{
		echo "<div class='error'><p>ERROR selecting users!" . $e->getMessage() . "</p></div>";
		exit();
	}
}

/**
 * HASH SENSITIVE DATA
 * Used for passwords and other sensitive data
 * If checked for matching fields, do NOT hash and insert both to the DB
 * @param $password
 * @return bool|string
 */
function hashPassword($password)
{
	$hashedpassword = password_hash($password, PASSWORD_BCRYPT);
	return $hashedpassword;
}

/**
 * @param $pdo
 * @param $password
 * @param $username
 * @return bool
 */
function verifyPassword($pdo, $password, $username)
{
	try
	{
		$sql = "SELECT password FROM jhwinterUser WHERE username = :username";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		$result = $stmt->fetch();
		if (password_verify($password, $result['password']))
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * INSERT INTO THE DATABASE
 * NOT ALL data comes from the form - Watch for this!
 *    For example, input dates are not entered from the form
 * @param $pdo
 * @param $formdata
 * @param $hashedpassword
 * @param $timestamp
 * @return mixed
 */
function insertUserIntoDB($pdo, $formdata, $hashedpassword, $timestamp)
{
	try
	{
		$sql = "INSERT INTO jhwinterUser (username, email, password, bio, inputDate)
				VALUES (:username, :email, :password, :bio, :inputDate)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':username', $formdata['username']);
		$stmt->bindValue(':email', $formdata['email']);
		$stmt->bindValue(':password', $hashedpassword);
		$stmt->bindValue(':bio', $formdata['bio']);
		$stmt->bindValue(':inputDate', $timestamp);
		return $stmt->execute();
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * @param $pdo
 * @param $formdata
 * @return mixed
 */
function updateUserInDB($pdo, $formdata)
{
	try
	{
		$sql = "UPDATE jhwinterUser 
				SET username = :username, email = :email, bio = :bio
				WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':username', $formdata['username']);
		$stmt->bindValue(':email', $formdata['email']);
		$stmt->bindValue(':bio', $formdata['bio']);
		$stmt->bindValue(':id', $formdata['id']);
		return $stmt->execute();
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * @param $pdo
 * @param $formdata
 * @return mixed
 */
function updateUserPasswordInDB($pdo, $formdata)
{
	try
	{
		$password = hashPassword($formdata['password']);
		$sql = "UPDATE jhwinterUser 
				SET password = :password
				WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':password', $password);
		$stmt->bindValue(':id', $formdata['id']);
		return $stmt->execute();
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * @param $currentfile
 * @param $afile
 * @param $listlink
 * @param $id
 */
function showIfCorrectUser($currentfile, $afile, $listlink, $id)
{
	if (isset($_SESSION['username']))
	{
		if ($id == $_SESSION['id'])
		{
			if ($currentfile == $afile)
			{
				echo $listlink;
			}
			else
			{
				echo "<a href=" . $afile . "?id=$id>$listlink:</a>\n";
			}
		}
	}
}
?>
