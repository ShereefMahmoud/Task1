<?php 

$id = $_GET['id'];
require '../classes/userClass.php';

# Create OBJ .... 
$user = new user; 

#######################################################################################

/////////////////show row
$Raw = $user->showUsers($id);


##########################################################################################

/////////edit data

if ($_SERVER['REQUEST_METHOD'] == "POST") {  

    $id = $_GET['id'];

$result =  $user->editUsers( $id ,$_POST , $_FILES) ;

foreach ($result as $key => $value) {
    # code...
    echo '* '.$key.' : '.$value.'<br>';
}


}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>

        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']). '?id=' . $Raw['id']; ?>" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" value="<?php echo $Raw['title'];?>" placeholder="Enter Title">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Content</label>
                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">value="<?php echo $Raw['content'];?>"</textarea>
            </div>


            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>

            <img src="../uploads/<?php echo $Raw['dir_img']; ?>" alt="UserImage"  height="100px"  width="100px"> 
            <br>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>