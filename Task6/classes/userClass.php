<?php 

  require 'dbClass.php';
  require 'validatorClass.php';

class user{
    
    private $name; 
    private $email; 
    private $password; 

    /**
     * Register Method .....
     * input   >>>> ARRAY CONTAINS INPUTS FROM USER .... 
     * output  >>>> FINAL RESULT 
     *  */  
    public function Register($input , $image){
       
       # Create OBJ FROM VALIDATOR CLASS ..... 
       $validator = new Validator; 

       # Clean &&  ASSIGN INPUTS TO PRO .... 
       $this->title     =  $validator->Clean($input['title']); 
       $this->content =  $validator->Clean($input['content']); 
       $this-> image_name =  $validator->Clean($image['image']['name']); 


       # VALIDATE INPUTS ..... 
       $Errors = [];
       $result = null;

        # Validate Name .... 
        if (!$validator->validate($this->title, 'required')) {
            $Errors['Title'] = "Field Required";
        }elseif (!$validator->validate($this->title, 'min' , 5)) {
            $Errors['Title'] = "Invalid Email Format";
        }

        # Validate Email .... 
        if (!$validator->validate($this->content, 'required')) {
            $Errors['Content'] = "Field Required";
        } elseif (!$validator->validate($this->content, 'min' , 50)) {
            $Errors['content'] = "Invalid Email Format";
        }


        # Validate  .... 

        if (!$validator->validate($this->image_name , 'required')) {
            $Errors['Image'] = "Field Required";
        } elseif (!$validator->validate($image , 'image')) {
            $Errors['Image'] = "Format Not Matching";
        }


        # Check Errors ..... 
        if (count($Errors) > 0) {
            $result = $Errors;
        } else {

            # DO CODE .....

            $typesInfo  =  explode('/', $image['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

            # Create Final Name ... 
            $FinalName = uniqid() . '.' . $extension;

            $disPath = '../uploads/' . $FinalName;

            $temPath = $image['image']['tmp_name'];

            if (move_uploaded_file($temPath, $disPath)) {
                # QUERY .... 
                $sql = "insert into user (title,content,dir_img) values ('$this->title','$this->content','$FinalName')";

                # DB OBJ ... 
                $dbObj = new db;

                $op = $dbObj->doQuery($sql);

                if ($op) {
                    $result = ["success" => "Raw Inserted"];
                } else {

                    $result = ["error" => "Error Try Again"];
                }
            } else {

                    $result = ["error" => "Error In Upploading Try Again"];
            }
        }


        return $result;
    }




    # Display Records .... 

    public function listUsers()
    {

        # DB OBJ ... 
        $dbObj = new db;

        # QUERY .... 
        $sql = "select * from user";

        $op = $dbObj->doQuery($sql);

        return $op;
    }


    public function deleteUsers($input)
    {


        $result = null ;

        # DB OBJ ... 
        $dbObj = new db;
        $validator = new Validator;

        # Fetch Id .... 
        $this->id = $input;

        # Validate Id .... 

        if (!$validator->validate($this->id, 'int')) {
            $result = ['ID', "Not Valid"] ;
        } else

            # Fetch image name .... 
            $sql  = "select dir_img from user where id = $this->id";
            $op = $dbObj->doQuery($sql);
            $data =  mysqli_fetch_assoc($op);


        $sql = "delete from user where id = $this->id";

        $op = $dbObj->doQuery($sql);

        if ($op) {

            $validator->removeFile($data['dir_img']);
            $result = ["Success" => "Raw Removed"];
        } else {
            $result = ["Error" => "Error Try Again"];
        }

        return $result ;
    }

    public function showUsers($input){
        $dbObj = new db ;
        $this->id = $input ;
        $sql = "select * from user where id = $this->id";
        $op = $dbObj->doQuery($sql);
        if(mysqli_num_rows($op)==0){
            $result = ["Error"=>"In Valid Id"];
        }else{
            $result = mysqli_fetch_assoc($op);
        }

        return $result;
    }

    

    public function editUsers($id , $input , $image ){
        # Create OBJ FROM VALIDATOR CLASS ..... 

        $dbObj = new db;
       $validator = new Validator; 
       $this->id = $id ;

       # Clean &&  ASSIGN INPUTS TO PRO .... 
       $this->title     =  $validator->Clean($input['title']); 
       $this->content =  $validator->Clean($input['content']); 
       $this-> image_name =  $validator->Clean($image['image']['name']); 


       # VALIDATE INPUTS ..... 
       $Errors = [];
       $result = null;
       $Raw = [];

       $sql ="select dir_img from user wher id = $this->id";
       $op = $dbObj ->doQuery($sql);
       if (mysqli_num_rows($op)==0) {
           # code..
           $Errors = ["Error"=>"Not Valid Id"];
       }else{
            $this->Raw = mysqli_fetch_assoc($op);
       }


        # Validate Name .... 
        if (!$validator->validate($this->title, 'required')) {
            $Errors['Title'] = "Field Required";
        }elseif (!$validator->validate($this->title, 'min' , 5)) {
            $Errors['Title'] = "Invalid Email Format";
        }

        # Validate Email .... 
        if (!$validator->validate($this->content, 'required')) {
            $Errors['Content'] = "Field Required";
        } elseif (!$validator->validate($this->content, 'min' , 50)) {
            $Errors['content'] = "Invalid Email Format";
        }


        # Validate  .... 

        if (!$validator->validate($this->image_name , 'required')) {
            $Errors['Image'] = "Field Required";
        } elseif (!$validator->validate($image , 'image')) {
            $Errors['Image'] = "Format Not Matching";
        }


        # Check Errors ..... 
        if (count($Errors) > 0) {
            $result = $Errors;
        } else {

            # DO CODE .....
            if($validator->validate($this->image_name , 'required')){

            $typesInfo  =  explode('/', $image['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

            # Create Final Name ... 
            $FinalName = uniqid() . '.' . $extension;

            $disPath = '../uploads/' . $FinalName;

            $temPath = $image['image']['tmp_name'];

            if (move_uploaded_file($temPath, $disPath)) {
                unlink('../uploads/'.$this->Raw['dir_img']);
            }
        }else{
           $FinalName = $this->Raw['dir_img'] ;
        }
                # QUERY .... 
                $sql = "update  user   set title = '$this->title' , content = '$this->content' , dir_img = '$FinalName'  where id = $this->id";

                # DB OBJ ... 
                

                $op = $this->dbObj->doQuery($sql);

                if ($op) {
                    $result = ["Success" => "Raw Updated"];
                } else {

                    $result = ["Error" => "Error Try Again"];
                }
        }


        return $result;
    }

} 

