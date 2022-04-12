<?php 

session_start();

//////// Connection db /////////
require "helpers/conn.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $_POST['id'];
    $img_dir = $_POST['img_dir'];


    if (filter_var($id,FILTER_VALIDATE_INT)) {
        # code...
        /////////// Delete Post From DB ///////////
        $sql = "delete from post where id = $id";
        $delete = mysqli_query($conn , $sql);
    
        if ($delete) {
            # code...
            unlink($img_dir);
            $message = "Success delete";
        }else{
            $message = "Fail delete";
        }
    }else{
        $message = "Invalid Id";
    }
    
    mysqli_close($conn);
    
    $_SESSION['message']= $message ;
    
    header('location: index.php');
}
