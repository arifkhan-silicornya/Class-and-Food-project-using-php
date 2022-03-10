<?php

   $host = "localhost";
   $dbUsername = "root";
   $dbPassword = "";
   $dbName     = "food";


// ...................create connection .................
   
   $connect = mysqli_connect($host, $dbUsername, $dbPassword,$dbName);

   if($connect==false){
      
   echo "<center><h1><font color='red'> <i>Error Stablishing Database Connection !</i> <font></h1></center>";
      
   }	
	



?>