<?php

    //Print Next Character
function printNextChar($char){
    $nextChar = ++$char;
    if (strlen($nextChar ) > 1) {
        # code...
        $nextChar = $nextChar[0];
    }
    echo $nextChar . '<br>';
}

//Get the Characters After the last '/'
function getChar($string){
    # code......
    //strpos -> point to first position of char  ////strrpos -> point to last position of char
    $position = strrpos($string , '/') + 1 ;  
    echo substr($string,$position);
} 

printNextChar('a');
printNextChar('A');
printNextChar('z');
printNextChar('Z');

getChar('http://www.example.com/5478631');
?>