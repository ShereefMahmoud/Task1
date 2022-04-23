<?php 
 
  class Validator{

    function Clean($input)
{

    return stripslashes(strip_tags(trim($input)));
}



function validate($input, $flag,$length = 6)
{

    $status = true;

    switch ($flag) {
        case 'required':
            # code...
            if (empty($input)) {
                $status = false;
            }
            break;

        case 'email':
            # code ... 
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;

        case 'int':
            # code ... 
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;



        case 'min':
            # code ... 
            if (strlen($input) < $length) {
                $status = false;
            }
            break;


        case 'phone':
            # code ... 
            if (!preg_match('/^01[0-2,5][0-9]{8}$/', $input)) {
                $status = false;
            }
            break;



        case 'image':
            # Case 

            $typesInfo  =  explode('/', $input['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

            $allowedExtension = ['png', 'jpeg', 'jpg'];   // allowed Extension    // PNG JPG 

            if (!in_array($extension, $allowedExtension)) {

                $status = false;
            }

            break; 



          case 'date': 
                    
            $date = explode('-',$input); 
             
            if(!checkdate( $date[1],$date[2],$date[0])){
               $status = false; 
            }
            
            break;   


            case 'DateNext': 
                    if(time() > strtotime($input)){
                       $status = false;    
                    }
                break;

  


    }

    return $status;
}

public function removeFile($file){
   
    if(unlink('../uploads/'.$file)){
        $status = true;
    } else{
        $status = false; 
    }

    return $status;
}


  }







//   $obj = new Validator; 


// //   $input = "<h1>Root Account</h1>";
  
// //   echo $obj->Clean($input);


// $email = "test@test.com";

//   var_dump($obj->validate($email,'email'));