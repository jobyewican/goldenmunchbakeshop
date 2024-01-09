<?php
    $hostname = 'localhost';
    
    //  for server
//    $user     = 'vbxqsvvqad';
//    $password = 'TR7JN9kKCr';
//    $database = 'vbxqsvvqad';
    
    //  for localhost
    $user     = 'root';
    $password = '';
    $database = 'vbxqsvvqad';
    
    $conn = mysqli_connect($hostname, $user, $password, $database);
    
    if ( ! $conn )
    {
        echo "<script> alert('Error connecting to the database.'); </script>";
    }
