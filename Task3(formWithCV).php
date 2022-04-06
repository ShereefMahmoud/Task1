<?php

//Function To clean Data
function cleanData($input)
{
    return trim(strip_tags(stripslashes($input)));
}

// get data from form 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];


    $name     = cleanData($_POST['name']);
    $email    = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);
    $address  = cleanData($_POST['address']);
    $linkedIn = cleanData($_POST['linkedIn']);
    $gender   = $_POST['gender'];



    # code...

    //Validate CV
    if (!empty($_FILES['cv']['name'])) {
        $fname    = $_FILES['cv']['name'];
        $ftemPath = $_FILES['cv']['tmp_name'];
        $ftype    = $_FILES['cv']['type'];
        $fsize    = $_FILES['cv']['size'];



        $typeInfo  = explode('/', $ftype);
        $extention = strtolower(end($typeInfo));

        $allowExtention = ['pdf'];

        if (in_array($extention, $allowExtention)) {
            # code...
            $finalName = time() . rand() . $extention;

            $distPath = "upload/" . $finalName;
        } else {
            $errors['cv'] = 'InValid Extension';
        }
    } else {
        $errors['cv'] = 'Required';
    }





    // Validate Name 
    if (empty($name)) {
        $errors['name'] = "Required";
    } elseif (!is_string($name)) {
        $errors['name'] = "Should be String";
    }

    // Validate email 
    if (empty($email)) {
        $errors['email'] = "Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = " Not Matching ";
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = " Required ";
    } elseif (strlen($password) < 6) {
        $errors['password'] = " Very Short ";
    }

    // Validate Address
    if (empty($address)) {
        $errors['address'] = "Required";
    } elseif (strlen($address) <= 10) {
        $errors['address'] = " Shoud be More than  10 Chars ";
    }

    // Validate LinkedIn
    if (empty($linkedIn)) {
        $errors['linkedIn'] = "Required";
    } elseif (!filter_var($linkedIn, FILTER_VALIDATE_URL)) {
        $errors['linkedIn'] = " Should be URL";
    }

    // Validate LinkedIn
    if ($gender == 'select') {
        $errors['gender'] = "Required";
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
        echo "<script>window.alert(' Done Register '); </script>";
    }
}



?>

<!doctype html>
<html lang="en">

<head>
    <title>Register Form</title>
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
            /*height: 95vh;*/
            margin: auto;
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
            <h2 class="reg_header"> Register</h2>

            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputName1">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="emsil" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>

            <div class="mb-3">
                <label for="exampleInputAddress1" class="form-label">Address</label>
                <input type="address" name="address" class="form-control" id="exampleInputAddress1">
            </div>

            <div class="mb-3">
                <label for="exampleInputLinkedIn1" class="form-label">LinkedIn</label>
                <input type="url" name="linkedIn" class="form-control" id="exampleInputLinkedin1">
            </div>

            <div>
                <label for="exampleInputName1" class="form-label">Gender</label>
                <select name="gender" class="form-select" aria-label="Default select example">
                    <option value="select" selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Your CV</label>
                <input class="form-control" type="file" name="cv" id="formFile">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>



    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>