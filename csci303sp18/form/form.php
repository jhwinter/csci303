<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/02/06
 * Time: 11:42
 */

$pagename = 'My Page Name';
require_once "header.inc.php";
?>
    <form action="process.php" method="POST" name="countryForm" id="countryForm">
        <fieldset>
            <legend>Details</legend>
            <table>
                <tr>
                    <th><label for="title">Title:</label></th>
                    <td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <th><label for="where">Country:</label></th>
                    <td>
                        <select name="where" id="where">
                            <option>Choose a country</option>
                            <option>Canada</option>
                            <option>Finland</option>
                            <option>United States</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="username">Username:</label></th>
                    <td><input type="text" name="username" id="username" /></td>
                </tr>
                <tr>
                    <th><label for="email">Email:</label></th>
                    <td><input type="email" name="email" id="email" /></td>
                </tr>
                <tr>
                    <th><label for="url">URL:</label></th>
                    <td><input type="url" name="url" id="url" /></td>
                </tr>
                <tr>
                    <th><label for="password">Password:</label></th>
                    <td><input type="password" name="password" id="password" /></td>
                </tr>
                <tr>
                    <th><label>Radio a, b, c:</label></th>
                    <td>
                        <input type="radio" name="radio" id="radioa" />
                        <label for="radioa">a</label>
                        <input type="radio" name="radio" id="radiob" />
                        <label for="radiob">b</label>
                        <input type="radio" name="radio" id="radioc" />
                        <label for="radioc">c</label>
                    </td>
                </tr>
                <tr>
                    <th><label for="comments">Comments:</label></th>
                    <td><textarea name="comments" id="comments"></textarea></td>
                </tr>
                <tr>
                    <th><label for="submit">Submit:</label></th>
                    <td>
                        <input type="hidden"  name="hid" id="hid" />
                        <input type="submit" name="submit" id="submit" />
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
<?php
require_once "footer.inc.php";
?>