<?php 

$file =   fopen('info.txt','r')  or die("can't open file");

//////// Display Data From File.text //////////////

while(!feof($file)){
echo  fgets($file) . "<br>";
}

fclose($file);

//// Delete File

//unlink("info.txt");

?>