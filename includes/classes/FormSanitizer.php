<?php
class FormSanitizer
{

    public static function sanitizeFormString($inpuText){
        $inpuText = strip_tags($inpuText);
        $inpuText = str_replace(" ", "", $inpuText); // remove all space
        //$inpuText = trim($inpuText); // replace space after and before
        $inpuText = strtolower($inpuText);  
        $inpuText = ucfirst($inpuText);
        return $inpuText;
    }

    public static function sanitizeFormPassword($inpuText){
        $inpuText = strip_tags($inpuText);
        return $inpuText;
    }

    public static function sanitizeFormEmail($inpuText){
        $inpuText = strip_tags($inpuText);
        $inpuText = str_replace(" ", "", $inpuText); // remove all space
        return $inpuText;
    }

    public static function sanitizeFormNumber($inpuText){
        $inpuText = strip_tags($inpuText);
        $inpuText = str_replace(" ", "", $inpuText); // remove all space
        return $inpuText;
    }
    
}
?>
