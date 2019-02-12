<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/04/24
 * Time: 00:55
 */



/**
 * show the link if the user is allowed to view it
 * @param $currentfile
 * @param $afile
 * @param $listlink
 * @param $id
 * @param $userID
 */
function showIfCorrectUser($currentfile, $afile, $listlink, $id, $userID)
{
	if (isset($_SESSION['username']))
	{
		if (($userID == $_SESSION['id']) || ($_SESSION['username'] == 'admin'))
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

/**
 *
 * @param $pdo 		database connection
 * @return mixed 	returns an associative array of content ids and titles
 */
function getAllContent($pdo)
{
	try
	{
		$sql = "SELECT id, title, userID FROM jhwinterContent ORDER BY title";
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
 * @param $pdo 		database connection
 * @param $id 		content id
 * @return mixed 	returns an associative array of content ids and titles
 */
function getContent($pdo, $id)
{
	try
	{
		$sql = "SELECT * FROM jhwinterContent WHERE id = :id";
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
 * @param $pdo
 * @param $id
 * @return mixed
 */
function getContentWithUsername($pdo, $id)
{
	try
	{
		$sql = "SELECT C.id, C.title, C.category, C.details, C.inputDate, C.userID, U.username 
				FROM jhwinterContent C
				RIGHT JOIN jtwintersUser U ON C.userID=U.id 
				WHERE C.id = :id";
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
 * INSERT INTO THE DATABASE
 * NOT ALL data comes from the form - Watch for this!
 *    For example, input dates are not entered from the form
 * @param $pdo
 * @param $formdata
 * @param $timestamp
 * @return mixed
 */
function insertContentInDB($pdo, $formdata, $userID, $timestamp)
{
	try
	{
		$sql = "INSERT INTO jhwinterContent (title, category, details, userID, inputDate)
				VALUES (:title, :category, :details, :userID, :inputDate)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':title', $formdata['title']);
		$stmt->bindValue(':category', $formdata['category']);
		$stmt->bindValue(':details', $formdata['details']);
		$stmt->bindValue(':userID', $userID);
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
function updateContentInDB($pdo, $formdata)
{
	try
	{
		$sql = "UPDATE jhwinterContent 
				SET title = :title, category = :category, details = :details
				WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':title', $formdata['title']);
		$stmt->bindValue(':category', $formdata['category']);
		$stmt->bindValue(':details', $formdata['details']);
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
 * @param $id
 * @return mixed
 */
function deleteContentInDB($pdo, $id)
{
	try
	{
		$sql = "DELETE FROM jhwinterContent WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		return $stmt->execute();
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

/**
 * @param $pdo
 * @param $searchterm
 * @return int
 */
function searchContentInDB($pdo, $searchterm)
{
	try
	{
		$sql = "SELECT id, title 
				FROM jhwinterContent 
				WHERE (title LIKE '%$searchterm%') OR 
				(details LIKE '%$searchterm%') OR 
				(category LIKE '%$searchterm%') 
				ORDER BY title";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$resultcount = $stmt->rowCount();
		if ($resultcount < 1)
		{
			return 0;
		}
		else
		{
			return $result;
		}
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
}

?>
