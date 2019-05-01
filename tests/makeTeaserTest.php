<?php

use BthnTx\teaser;
use PHPUnit\Framework\TestCase;

class makeTeaserTest extends TestCase
{


    public $url;
    public $urlText;
    public $testText;
    public $testText1;
    public $testText2;
    public $testText3;

    protected function setUp(): void
    {
        $this->testText = <<<EEE
I quickly learned how fishy this world could be. A client 3,000 times I knew who
specialized in auto loans invited me up to his desk to show me how
to structure subprime debt. Eager to please, I promised I could
enhance my software to model his deals in less than a month. But when
I glanced at the takeout in the deal, I couldn't believe my eyes.
EEE;
        $this->testText1 = 'longwoooordjustcantbreakitatallsorryloremipsumloremipsumloremipsumloremipsum';
        $this->testText2 = '123,23123123.123123.2323';
        $this->testText3 = 'I quickly learned how fishy. 123123.2323';
        $this->url = 'http://some.url';
        $this->urlText = 'Read more';


    }

    public function testMakeEmptyTeaser()
    {
        $this->expectExceptionMessage('Empty content.');
        $teaser = teaser::makeTeaser('', $this->url, $this->urlText, 49, 50);

    }

    public function testMakeMaxMinLengthMessTeaser()
    {
        $this->expectExceptionMessage('Max length shorter than min length.');
        $teaser = teaser::makeTeaser($this->testText1, $this->url, $this->urlText, 65, 50);
    }

    public function testMakeContentLessMinLengthTeaser()
    {
        $teaser = teaser::makeTeaser($this->testText3, $this->url, $this->urlText, 220);
        $this->assertStringContainsString($teaser,$this->testText3);

    }


    public function testMakeContentLongOneWordTeaser()
    {
        $this->expectExceptionMessage('Teaser is continuous.');
        $teaser = teaser::makeTeaser($this->testText1, $this->url, $this->urlText, 20, 50);
    }

    public function testMakeContentLongNumberTeaser()
    {
        $this->expectExceptionMessage('Continuous number inside.');
        $teaser = teaser::makeTeaser($this->testText2, $this->url, $this->urlText, 20, 25);


    }


    public function testMakeTeaser()
    {
        $teaser = teaser::makeTeaser($this->testText, $this->url, $this->urlText, 49, 50);
        $expectedResult = "I quickly learned how fishy this world could <a href=\"{$this->url}\">{$this->urlText}</a>";
        $this->assertStringContainsString($teaser,$expectedResult);
    }

    public function testMakeTeaserWithNumbers()
    {
        $teaser = teaser::makeTeaser($this->testText, $this->url, $this->urlText, 20, 65);
        $expectedResult = "I quickly learned how fishy this world could be. A client <a href=\"{$this->url}\">{$this->urlText}</a>";
        $this->assertStringContainsString($teaser,$expectedResult);

    }

    public function testMakeTeaserIsWholeArticle()
    {
        $teaser = teaser::makeTeaser($this->testText, $this->url, $this->urlText, 200, 600);
        $this->assertStringContainsString($teaser,$this->testText);

    }

    public function testMakeTeaserNotAbsoluteURL()
    {
        $this->expectExceptionMessage('URL not absolute.');
        $teaser = teaser::makeTeaser($this->testText, '/'.$this->url, $this->urlText, 200, 600);
        $this->assertStringContainsString($teaser,$this->testText);

    }


}
