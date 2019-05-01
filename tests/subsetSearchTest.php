<?php


use BthnTx\subsetSearch;
use PHPUnit\Framework\TestCase;

class subsetSearchTest extends TestCase
{

    public $test0;
    public $test1;
    public $test2;
    public $test3;
    public $test4;
    public $test5;

    protected function setUp(): void
    {
        $this->test0 = ['a', 'b', 'b'];
        $this->test1 = ['a', 'b', 'b', 'a', 'b', 'b', 'b', 'a', 'b', 'c', 'b', 'b', 'c', 'b', 'b', 'c'];
        $this->test2 = ['b', 'r', 'o', 'w', 'n', 'f', 'o', 'x', 'h', 'u', 'n', 't', 'e', 'r', 'n', 'f', 'o', 'x', 'r', 'y', 'h', 'u', 'n'];
        $this->test3 = ['asd' => 'a', 'dsadsad' => 'aq', 'ws', 'ws', 'itsc' => 'aq'];
        $this->test4 = ['a', 'b', 'dd', 'e'];
        $this->test5 = [1, 1, 2, 3,3,3,6,7,8,3,3,3,4];
        $this->test6 = [1, 1, 2, 33];


    }


    public function testEmptyArraySolveTest()
    {
        $result = subsetSearch::solve([]);
        $this->assertNull($result, 'Should be null');

    }

    public function testShortArraySolve()
    {
        $result = subsetSearch::solve($this->test0);
        $this->assertTrue(['a'] == $result, 'Should be a');
    }

    public function testArraySolve()
    {
        $result = subsetSearch::solve($this->test1);
        $this->assertTrue(array('b', 'b', 'a', 'b') == $result, 'Should be bbab');

        $result = subsetSearch::solve($this->test2);
        $this->assertTrue(array('n', 'f', 'o', 'x') == $result, 'Should be nfox');

    }

    public function testAssociativeArrayExceptionSolve()
    {
        $this->expectExceptionMessage('Associative array instead of sequential');
        $result = subsetSearch::solve($this->test3);

    }


    public function testMulticharElementsExceptionSolve()
    {
        $this->expectExceptionMessage('Array element longer 1 char');
        $result = subsetSearch::solve($this->test4);

    }

    public function testNumericSetSolve()
    {
        $result = subsetSearch::solve($this->test5);
        $this->assertTrue([3,3,3] == $result, 'Should be 333');

    }


    public function testMultiNumericElementsExceptionSolve()
    {
        $this->expectExceptionMessage('Array element longer 1 char');
        $result = subsetSearch::solve($this->test6);

    }


}
