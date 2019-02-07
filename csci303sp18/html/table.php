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
        <title>Jonathan Winter</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <header>
            <h1>Linux Distros</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="form.php">Form</a></li>
                    <li>Table</li>
                </ul>
            </nav>
        </header>
        <main>
            <h2>Linux</h2>
            <table>
                <caption>Types of Linux Distros</caption>
                <tr><th>Base</th><th>Intermediate</th><th>Advanced</th></tr>
                <tr><th rowspan="2">Debian-based</th><td>Ubuntu</td><td>Kali Linux</td></tr>
                <tr><td>Tails</td><td>Grml</td></tr>
                <tr><th rowspan="2">Arch-based</th><td>Antergos</td><td>Arch Linux</td></tr>
                <tr><td>Artix Linux</td><td>BlackArch Linux</td></tr>
            </table>
        </main>
        <footer>
            23 January 2018
        </footer>
    </body>
</html>
