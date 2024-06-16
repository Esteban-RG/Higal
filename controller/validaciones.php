<?php

function validateName($nombre){
    if (preg_match('/[0-9]/', $nombre)) {
        return false;
    } else {
        return true;
    }
}

function validateEmail($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
}

function validateDate($date){
     $currentDate = new DateTime();
     $inputDate = new DateTime($date);
     
     if ($inputDate > $currentDate) {
            return true;
     }else{
        return false;
     }
}
?>
