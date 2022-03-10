<?php

   $host = "localhost";
   $dbUsername = "root";
   $dbPassword = "";
   $dbName     = "project";


// ...................create connection .................
   
   $conn = mysqli_connect($host, $dbUsername, $dbPassword,$dbName);

   if($conn==false){
      
   echo "<center><h1><font color='red'> <i>Error Stablishing Database Connection !</i> <font></h1></center>";
      
   }	
	



?>