<?php
namespace AnalyzerTest;

include_once('analyzer.php');

use Analyzers;
use PHPUnit\Framework\TestCase;


class AnalyzerTest extends TestCase
{
    private $SimpleAnalyzer;
    private $StopAnalyzer;
    private $StandardAnalyzer;
    private $FingerprintAnalyzer;

    public function setUp(): void
    {
        $text = "The 2 QUICK Brown-Foxes jumped over the lazy dog's bone.";
        $this->SimpleAnalyzer = new Analyzers\SimpleAnalyzer($text);
        $this->StopAnalyzer = new Analyzers\StopAnalyzer($text);
        $this->StandardAnalyzer = new Analyzers\StandardAnalyzer($text);
        $this->FingerprintAnalyzer = new Analyzers\FingerprintAnalyzer($text);
    }

    public function testSimpleAnalyze()
    {
        $this->SimpleAnalyzer->analyze();
        $simpleTerms = $this->SimpleAnalyzer->getTerms();
        $expectedSimpleTerms = array(
            "the", "quick", "brown", "foxes", "jumped", "over",
            "the", "lazy", "dog", "s", "bone"
        );
        $this->assertEquals($expectedSimpleTerms, $simpleTerms);
    }

    public function testStopAnalyze()
    {
        $this->StopAnalyzer->analyze();
        $stopTerms = $this->StopAnalyzer->getTerms();
        $expectedStopTerms = array("quick", "brown", "foxes", "jumped", "lazy", "dog", "bone");
        $this->assertEqualsCanonicalizing($expectedStopTerms, $stopTerms);
    }

   public function testStandardAnalyze()
    {
        $this->StandardAnalyzer->analyze();
        $standardTerms = $this->StandardAnalyzer->getTerms();
        $expectedStandardTerms = array(
            "the", "2", "quick", "brown", "foxes", "jumped",
            "over", "the", "lazy", "dog's", "bone"
        );
        $this->assertEqualsCanonicalizing($expectedStandardTerms, $standardTerms);
    }

    public function testFingerprintAnalyze()
    {
        $this->FingerprintAnalyzer->analyze();
        $fingerprintTerms = $this->FingerprintAnalyzer->getTerms();
        $expectedFingerprintTerms = array(
            "2", "bone", "brown", "dog's", "foxes", "jumped",
            "lazy", "over", "quick", "the"
        );
        $this->assertEqualsCanonicalizing($expectedFingerprintTerms, $fingerprintTerms);
    }

}
