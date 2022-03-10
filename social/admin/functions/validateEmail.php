<?php
function SK_validateEmail($string='') {
    $regex = '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
    
    if (preg_match($regex, $string)) {
        return true;
    }
    
    return false;
}
