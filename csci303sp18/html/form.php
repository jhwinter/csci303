<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/01/23
 * Time: 10:58
 */
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Jonathan Winters</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <header>
            <h1>Linux Distros</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li>Form</li>
                    <li><a href="table.php">Table</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <h2>Linux</h2>
                <form action="process.php" method="POST" name="countryForm" id="countryForm">
                    <fieldset>
                        <legend>Details</legend>
                        <table>
                            <tr>
                                <th><label for="title">Title</label></th>
                                <td><input type="text" name="title" id="title" /></td>
                            </tr>
                            <tr>
                                <th><label for="where">Country: </label></th>
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
                                <th><label for="username">text</label></th>
                                <td>please enter your username: <input type="text" name="username" id="username" /></td>
                            </tr>
                            <tr>
                                <th><label for="email">email</label></th>
                                <td><input type="email" name="email" id="email" /></td>
                            </tr>
                            <tr>
                                <th><label for="url">url</label></th>
                                <td><input type="url" name="url" id="url" /></td>
                            </tr>
                            <tr>
                                <th><label>hidden</label></th>
                                <td><input type="hidden"  name="hid" id="hid" /></td>
                            </tr>
                            <tr>
                                <th><label for="password">password</label></th>
                                <td><input type="password" name="password" id="password" /></td>
                            </tr>
                            <tr>
                                <th><label>radio a, b, c</label></th>
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
                                <th><label for="comments">textarea</label></th>
                                <td><textarea name="comments" id="comments">this is a textarea</textarea></td>
                            </tr>
                            <tr>
                                <th><label for="submit">Submit: </label></th>
                                <td><input type="submit" name="submit" id="submit" /></td>
                            </tr>
                        </table>

                    </fieldset>
                </form>
        </main>
        <footer>
            23 January 2018
        </footer>
    </body>
</html>
