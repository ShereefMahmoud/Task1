<?php

//Function To clean Data
function cleanData($input)
{
    return trim(strip_tags(stripslashes($input)));
}

// get data from form 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];


    $title     = cleanData($_POST['title']);
    $content    = cleanData($_POST['content']);

    # code...

    //Validate CV
    if (!empty($_FILES['image']['name'])) {
        $fname    = $_FILES['image']['name'];
        $ftemPath = $_FILES['image']['tmp_name'];
        $ftype    = $_FILES['image']['type'];
        $fsize    = $_FILES['image']['size'];



        $typeInfo  = explode('/', $ftype);
        $extention = strtolower(end($typeInfo));

        $allowExtention = ['png','jpeg','jpg'];

        if (in_array($extention, $allowExtention)) {
            # code...
            $finalName = time() . rand() . $extention;

            $distPath = "upload/" . $finalName;
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
    } elseif (strlen($content) < 50 ) {
        $errors['content'] = " Less Than Allowed ";
    }

    // Check error
    if (count($errors) > 0) {
        # code...
        foreach ($errors as $key => $value) {
            echo  "<script> window.alert (' " . $key . " : " . $value . " ');</script>";
        }
    } elseif (!move_uploaded_file($ftemPath, $distPath)) {

        echo "<script>window.alert(' Try Again '); </script>";
    } else {

        /////////// Create Or Open file And Write in File /////////// 

        $file =   fopen('info.txt','a')  or die("can't open file");

        $text = "Title : " . $title . " .\n" ;
        fWrite($file,$text);

        $text = "Content : " . $content . " .\n" ;
        fWrite($file,$text);

        fclose($file) ;

        echo "<script>window.alert(' Done Save Data '); </script>";
    }
}



?>

<!doctype html>
<html lang="en">

<head>
    <title>Post</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .all {
            /*background-color: lightblue;*/
            background-image: linear-gradient(to right, lightblue, azure);
        }

        .box {
            width: 50%;
            height: 65vh;
            margin: 18vh  auto ;
            /*background-color:azure;*/
            background-image: linear-gradient(to left, lightblue, azure);
            border-radius: 20px;
        }


        .box div {
            margin: 15px 20px;
        }

        .box button {
            margin-left: 45%;
        }

        .reg_header {
            text-align: center;
            padding-top: 10px;
            margin-bottom: 5px;
        }
    </style>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body class="all">
    <div class="box">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
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
                <label for="formFile" class="form-label">Upload Your Image</label>
                <input class="form-control" type="file" name="image" id="formFile">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>



    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>