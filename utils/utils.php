<?php

function readTexttoArray($filename){
    $contents = file_get_contents($filename);
    return preg_split("/\s+/", $contents);
}

function saveToText($content, $file_name='debug.txt'){
    $out = fopen($file_name, 'w');
    fputs($out, $content);
    fclose($out);
}

function checkFileTimeout(){
    $timeout = 60;
    if (time() - $_SESSION['analysis_timestamp'] > $timeout){
        $filename = (string)$_SESSION['file_id'] . '.txt';
        unlink($filename);
        session_unset();
        return True;
    }
    return False;
}