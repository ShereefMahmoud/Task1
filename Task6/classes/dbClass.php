<?php 

session_start();

class  db{

   var $server     = "localhost"; 
   var $dbName     = "group13";
   var $dbUser     = "root"; 
   var $dbPassword = "";  
   var $con ;  


    function __construct()
    {
        $this->con =  mysqli_connect($this->server,$this->dbUser,$this->dbPassword,$this->dbName);
        
        if(!$this->con){
            die ("Error Try Again , Error : ".mysqli_connect_error() );
        }
    }



    function doQuery($sql){
     
     return mysqli_query($this->con,$sql);
    
    }



    function __destruct()
    {
          mysqli_close($this->con);
    }


}




// $obj = new db;

// $sql = "insert into category (title) values ('cs')";

// $op = $obj -> doQuery($sql); 

// if($op){
//     echo 'Raw Inserted';
// }else{
//     echo 'Error Try again';
// }
