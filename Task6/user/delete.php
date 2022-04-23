<?php

$id = $_GET['id'];
require '../classes/userClass.php';
# Create OBJ .... 
$user = new user; 

$result = $user->deleteUsers($id);

foreach ($result as $key => $value) {
    # code...
    echo '* '.$key.' : '.$value.'<br>';
}


?>