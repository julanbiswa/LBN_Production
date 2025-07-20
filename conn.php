<?php
   
   error_reporting(0);  

    $conn = new mysqli("localhost", "root", "", "UProduction_db");
    // $conn = new mysqli("sql311.infinityfree.com", "if0_39434996", "bCQ79Fquezp6o0", "if0_39434996_lnbproduction");


   if($conn){
     //    echo "Connection Okey!";
   }else{
    echo "Connection error!".mysqli_connect_error();
   }
?>