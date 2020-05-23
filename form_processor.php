<?php
session_start();

include_once('analyzer.php');
include_once('constants.php');
use Analyzers;


class FormProcessor{
    public $analyzer;
    public $text;
    public $formData;

    function __construct($data){
        $this->formData = $data;
    }

    public function getAnalyzer(){
        $this->analyzer = $this->formData['analyzer'];
        return $this->analyzer;
    }

    public function getText(){
        $this->text = $this->formData['text'];
        return $this->text;
    }
}

$processor = new FormProcessor($_POST);
$analyzer_choice = $processor->getAnalyzer();
$text = $processor->getText();


switch ($analyzer_choice){
    case analyzers["standard"]:
        $analyzer = new Analyzers\StandardAnalyzer($text);
        break;
    case analyzers["whitespace"]:
        $analyzer = new Analyzers\WhiteSpaceAnalyzer($text);
        break;
    case analyzers["stop"]:
        $analyzer = new Analyzers\StopAnalyzer($text);
        break;
    case analyzers["fingerprint"]:
        $analyzer = new Analyzers\FingerprintAnalyzer($text);
        break;
    case analyzers["simple"]:
        $analyzer = new Analyzers\SimpleAnalyzer($text);
        break;
}

$analyzer->analyze();
$terms = $analyzer->getTerms();
$_SESSION['is_analysed'] = True;
$min_random = 1000000;
$max_random = 10000000;
$_SESSION['file_id'] = mt_rand($min_random, $max_random);
$_SESSION['analysis_timestamp'] = time();

saveToText(implode(" ", $terms), (string)$_SESSION['file_id'].'.txt');
checkFileTimeout();

header("Location: index.php");
