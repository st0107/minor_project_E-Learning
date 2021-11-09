<?php

define('DB_SERVER','localhost:7882');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');

//connecting database

$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if($conn == false){
    dir('error : not connected')
}

?>