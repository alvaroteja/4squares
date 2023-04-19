<?php

$string = "asda@sd";

echo lessThan8Character($string);



function invalidPasswordFormat($string)
{
    /*
        Has minimum 8 characters in length. Adjust it by modifying {8,}
        At least one uppercase English letter. You can remove this condition by removing (?=.*?[A-Z])
        At least one lowercase English letter.  You can remove this condition by removing (?=.*?[a-z])
        At least one digit. You can remove this condition by removing (?=.*?[0-9])
        At least one special character,  You can remove this condition by removing (?=.*?[#?!@$%^&*-])
        */
    if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $string)) {
        return "pass not valid";
    }
    return false;
}
function lessThan8Character($string)
{
    if (!preg_match("/^.{8,}$/", $string)) {
        return "menos de 8 caracteres";
    }
    return false;
}
function noUppercaseletter($string)
{
    if (!preg_match("/.*[A-Z]/", $string)) {
        return "pass not valid";
    }
    return false;
}
function noLowcaseletter($string)
{
    if (!preg_match("/.*[a-z]/", $string)) {
        return "pass not valid";
    }
    return false;
}

function noDigit($string)
    {
        if (!preg_match("/.*[0-9]/", $string)) {
            return "pass not valid";
        }
        return false;
    }

function noSpecialCharacter($string)
{
    if (!preg_match("/.*[#?!@$%^&*-]/", $string)) {
        return "pass not valid";
    }
    return false;
}
