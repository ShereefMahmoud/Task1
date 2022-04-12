<?php

/////////connection Code file////////////
$server = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "nti";

$conn = mysqli_connect( $server , $dbUser , $dbPassword , $dbName );

if( !$conn ){
    echo "Error". mysqli_connect_error();
}
