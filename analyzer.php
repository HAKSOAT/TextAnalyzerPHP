<?php

namespace Analyzers;

include_once('constants.php');


interface Analyser{
    public function analyze();
    public function getTerms();
}


class SimpleAnalyzer implements Analyser{

    protected $text;
    protected $terms = array();

    function __construct($text)
    {
        $this->text = $text;
    }

    protected function lowercaseText(){
        $this->text = strtolower($this->text);
    }

    protected function split(){
        $is_matched = (bool)preg_match_all('/[A-Za-z]+/', strtolower($this->text), $matches);

        if ($is_matched){
            $this->terms = $matches[0];
        }
    }

    public function analyze(){
        $this->lowercaseText();
        $this->split();
    }

    public function getTerms(){
        return $this->terms;
    }

}


class StopAnalyzer extends SimpleAnalyzer{
    protected function removeStopwords(){
        global $stopwords;
        $this->terms = array_diff($this->terms, $stopwords);
    }

    public function analyze()
    {
        $this->lowercaseText();
        $this->split();
        $this->removeStopwords();
    }
}


class StandardAnalyzer extends StopAnalyzer{
    protected function split(){
        $is_matched = (bool)preg_match_all('/\b[\w\'_]+\b/', strtolower($this->text), $matches);

        if ($is_matched){
            $this->terms = $matches[0];
        }
    }

    public function analyze()
    {
        $this->lowercaseText();
        $this->split();
    }
}


class FingerprintAnalyzer extends StandardAnalyzer {
    protected function generateFingerprint(){
        $this->terms = array_unique($this->terms);
        sort($this->terms);
    }

    public function analyze(){
        $this->lowercaseText();
        $this->split();
        $this->generateFingerprint();
    }
}
