<?php

require_once("../../php/conect_database.php");


$username  = htmlentities("Admin_maruf");
$password    = md5(sha1("12345"));

$count = 0;

$sql="SELECT * FROM admin ";
$result=mysqli_query($connect,$sql);

while($row=mysqli_fetch_array($result))
    { 
        $count ++;
    }
if ($count == "0") {
    $insertDataInDb= "INSERT INTO admin (`username`,`admin_pass`) VALUES('$username','$password')";
    $runquery = mysqli_query($connect, $insertDataInDb);
    if ($runquery == true ) {
 
        header("location: ../index.php?loginNow");    
     }
     else{
        header("location: ../index.php?Failed!Don't_try");
     }
}
else {
    echo "Admin Already Created";
    header("location: ../index.php?already_u_have_one");
    
}


?>