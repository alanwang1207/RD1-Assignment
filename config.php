<!-- XAMPP -->
<!-- 
<?php

$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'test3';
$port = 3306;
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
mysqli_query($link, "set names utf-8");

?> -->

<!-- MAMP -->

<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'test3';
$port = 8889;
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
mysqli_query($link, "set names utf-8");

?>