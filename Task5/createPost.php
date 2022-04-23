<?php

session_start();
//////// Connection db /////////
require "helpers/conn.php";

///////////// Function  ////////
require "helpers/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];


    $title     = cleanData($_POST['title']);
    $content    = cleanData($_POST['content']);
    $date    = explode('-', $_POST['date']);

    # code...

    //Validate CV
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
        $errors['image'] = 'Required';
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
    } elseif (!move_uploaded_file($ftemPath, $img_dir)) {

        echo "<script>window.alert(' Try Again '); </script>";
    } else {

        /////////// Create A Post in DB /////////// 

        $sql = "insert into post (title , content , date , img_dir) values ('$title','$content','$date','$img_dir')";
        $create = mysqli_query($conn, $sql);

        if ($create) {
            $message = "Created Post";
        } else {
            $message = "Failed To Create Post";
        }

        mysqli_close($conn);
        $_SESSION['message'] = $message;
        header('location: show_tasks.php');
    }
}

///////// Header

include "helpers/header.php";

?>

<body class="all">
    <div class="box">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <h2 class="reg_header"> Post </h2>

            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Title </label>
                <input type="text" name="title" class="form-control" id="exampleInputName1">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Date</label>
                <input class="form-control" type="date" name="date" id="formFile">
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Your Image</label>
                <input class="form-control" type="file" name="image" id="formFile">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>






    <?php

    include "helpers/footer.php";

    ?>