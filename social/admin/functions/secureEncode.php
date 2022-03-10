<?php
function SK_secureEncode($string) {
    global $dbConnect;
    
    $string = trim($string);
    $string = mysqli_real_escape_string($dbConnect,$string);
    $string = str_replace('<','&#60;',$string);
    $string = str_replace('>','&#62;',$string);
    $string = str_replace("'",'&#39;',$string);
    $string = htmlspecialchars($string);
    $string = str_replace('\\r\\n','<br>',$string);
    $string = str_replace('\\n\\n','<br>',$string);
    $string = stripslashes($string);
    $string = str_replace('&amp;#','&#',$string);
    return $string;
}
