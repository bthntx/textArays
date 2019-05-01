<?php

namespace BthnTx;
use Exception;

final class subsetSearch
{

    /**
     * Largest repeated subset.
     * Find the longest repeated subset of array elements in given array. For example,
     * for array('b','r','o','w','n','f','o','x','h','u','n','t','e','r','n','f','o','x','r','y','h','u','n')
     * the longest repeated subset will be array('n','f','o','x').
     *
     * @param array $list
     * @return ?array
     * @throws Exception if associative array provided
     */
    public static function solve(Array $list):?array
    {

        $listLength = count($list);
        if ($listLength == 0) {
            //array is empty
            return null;
        }



        if (array_keys($list) !== range(0, $listLength - 1))
            throw new Exception('Associative array instead of sequential');

        array_map(function ($element){
            if (strlen((string)$element)>1) throw new Exception('Array element longer 1 char');
        },$list);

        $listLength = count($list);
        //there is no longer that 1 char length chunk in array of 3
        if ($listLength <= 3) {
            return [$list[0]];
        }

        //repeated chunk couldn't be longer than half of array's length
        $initialSubsetLength = intdiv($listLength, 2);


        //we starting from maximum length of chunk first repeated is our result
        for ($length = $initialSubsetLength; $length > 1; $length--) {
            // forming chunk variations depending on its length
            $variationsNumber = $listLength - $length;
            for ($j = 0; $j <= $variationsNumber; $j++) {
                $subsetVariant = array_slice($list, $j, $length);
                if (self::checkPattern($subsetVariant, $list, ($j + $length))) {
                    return ($subsetVariant);
                }
            }
        }
    }

    /**
     *
     * @param array $needle pattern that we are looking for
     * @param array $haystack
     * @param int $startPos start position for checking - in reality it is next position from needle last element
     * @return bool
     */
    public static function checkPattern($needle, $haystack, $startPos)
    {
        $needleLength = count($needle);
        $iterationNums = count($haystack) - $needleLength;

        for ($i = $startPos; $i <= $iterationNums; $i++) {
            $tmp_array = array_slice($haystack, $i, $needleLength);
            if ($needle === $tmp_array) {
                return true;
            }
        }

        return false;
    }
}







