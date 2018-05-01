<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Winter
 * Date: 18/01/30
 * Time: 11:29
 */

$currentfile = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <ul class="navbar-nav">
        <?php
        echo ($currentfile == "index.php") ? "<li class='nav-item'>Home</li>" : "<li class='nav-item'><a href='index.php' class='nav-link'>Home</a></li>";
		showIfLoggedIn($currentfile, 'contentsearch.php', 'Search Content');
		showIfLoggedIn($currentfile, 'contentmanage.php', 'Manage Content');
        showIfLoggedIn($currentfile, 'usermanage.php', 'Manage Users');
        showIfNotLoggedIn($currentfile, 'useradd.php', 'User Registration');
        echo (isset($_SESSION['username'])) ? "<li class='nav-item'><a href='logout.php' class='nav-link'>Log Out</a></li>" : "<li class='nav-item'><a href='login.php' class='nav-link'>Log In</a></li>";
        ?>
    </ul>
</nav>

