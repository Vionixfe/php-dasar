<?php
$host="localhost";
$user="root";
$pass="";
$db_name="php-dasar";

$db = mysqli_connect($host,$user,$pass,$db_name);

if(!$db){
    die("Connection failed: ".mysqli_connect_error());}
// } else {
//     echo "Connection Success";
// }