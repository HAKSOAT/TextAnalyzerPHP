<?php

include_once('utils/utils.php');

const analyzers = array(
    "standard" => "standard", "stop" => "stop",
    "fingerprint" => "fingerprint", "simple" => "simple"
);

$stopwords = readTexttoArray('utils/stopwords.txt');
?>