<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/01/30
 * Time: 11:22
 */

$pagename = "Home"; // pagename var is used in the header
require_once "header.inc.php";
require_once "contentfunctions.php";
?>
    <p class="text-white">
        Welcome! This is a site dedicated to hosting user-provided information about the blockchain.
        The content does not have to be specific to any particular blockchain technology or use case.
        The content is free and open to the public. You don't need an account to view the content,
        but you do need an account to post to the site.
    </p>
    <ol>
        <?php
        $result = getAllContent($pdo);
        foreach ($result as $row)
		{
		    $id = strval($row['id']);
			echo "<li><a href='contentview.php?id=" . $id . "'>" . $row['title'] . "</a></li>\n";
		}
        ?>
    </ol>
<?php require_once "footer.inc.php"; ?>