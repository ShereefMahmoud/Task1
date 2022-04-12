<?php

session_start();
$id = $_GET['id'];
//////// Connection db /////////
require "helpers/conn.php";

$sql = "select * from post where id = $id";
$showRow = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($showRow);

///////////// Function  ////////
require "helpers/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];


    $title      = cleanData($_POST['title']);
    $content    = cleanData($_POST['content']);
    $date    = explode('-', $_POST['date']);
    $image_old  = cleanData($_POST['image_old']);


    # code...

    //Validate  Image

    if (!empty($_FILES['image']['name'])) {
        $fname    = $_FILES['image']['name'];
        $ftemPath = $_FILES['image']['tmp_name'];
        $ftype    = $_FILES['image']['type'];
        $fsize    = $_FILES['image']['size'];



        $typeInfo  = explode('/', $ftype);
        $extention = strtolower(end($typeInfo));

        $allowExtention = ['png', 'jpeg', 'jpg'];

        if (in_array($extention, $allowExtention)) {
            # code...
            $finalName = time() . rand() . $extention;

            $img_dir = "uploaded_img/" . $finalName;
        } else {
            $errors['image'] = 'InValid Extension';
        }
    } else {
        $img_dir = $image_old;
    }





    // Validate title 
    if (empty($title)) {
        $errors['title'] = "Required";
    } elseif (!is_string($title)) {
        $errors['title'] = "Should be String";
    }

    // Validate content 
    if (empty($content)) {
        $errors['content'] = "Required";
    } elseif (strlen($content) < 50) {
        $errors['content'] = " Less Than Allowed ";
    }

    // Validate date 
    if (empty($date)) {
        $errors['date'] = "Required";
    } elseif (checkdate($date[0], $date[1], $date[2])) {
        $errors['date'] = "Not Matching";
    }

    // Check error
    if (count($errors) > 0) {
        # code...
        foreach ($errors as $key => $value) {
            echo  "<script> window.alert (' " . $key . " : " . $value . " ');</script>";
        }
    } else {

        /////////// Update Post in DB /////////// 

        $sql = "update post set title = '$title' , content = '$content' , date = '$date' , img_dir = '$img_dir' where id = $id";
        $update = mysqli_query($conn, $sql);

        if ($update) {
            if (!empty(!empty($_FILES['image']['name']))) {
                move_uploaded_file($ftemPath, $img_dir);
                unlink($image_old);
            }

            $message = "Updated Post";
        } else {
            $message = "Failed To Updated Post";
        }

        mysqli_close($conn);
        $_SESSION['message'] = $message;
        header('location: index.php');
    }
}


///////// Header

include "helpers/header.php";

?>

<body class="all">
    <div class="box" style="height: 90vh; margin-top :15px">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $data['id'];; ?>" method="POST" enctype="multipart/form-data">
            <h2 class="reg_header"> Post </h2>

            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Title </label>
                <input type="text" name="title" class="form-control" id="exampleInputName1" value="<?php echo $data['title']; ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"><?php echo $data['content']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Date</label>
                <input class="form-control" type="date" name="date" id="formFile" value="<?php echo $data['date']; ?>">
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Your Image</label>
                <input class="form-control" type="file" name="image" id="formFile" ?>
                <input class="form-control" type="hidden" name="image_old" id="formFile" value="<?php echo $data['img_dir']; ?>">

            </div>


            <img style="width: 100px; height:100px" src="<?php echo $data['img_dir']; ?>">
            <button type="submit" class="btn btn-primary">Save</button>


        </form>
    </div>






    <?php

    include "helpers/footer.php";

    ?>