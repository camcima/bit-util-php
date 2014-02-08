<?php

namespace Test;

use BitUtil\BitArray;
use BitUtil\BitStreamReader;
use BitUtil\BitStreamWriter;

/**
 * BitUtilTest
 */
class BitUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testBitArray()
    {
        /**
         * 	Test the bit array using the binary data
         * 	10000000 11111111 110
         */
        $array = new BitArray(19);
        for ($i = 0; $i < 19; $i++) {
            $this->assertEquals(0, $array[$i]);
            if ($i == 0 || ($i > 7 && $i < 18)) {
                $array[$i] = 1;
            } else {
                $array[$i] = 0;
            }
        }

        for ($i = 0; $i < 19; $i++) {
            if ($i == 0 || ($i > 7 && $i < 18)) {
                $this->assertEquals(1, $array[$i]);
            } else {
                $this->assertEquals(0, $array[$i]);
            }
        }

        //	double-check the internal representation 
        $vals = unpack("C*", $array->getData());
        $this->assertEquals(1, $vals[1]);
        $this->assertEquals(255, $vals[2]);
        $this->assertEquals(3, $vals[3]);


        //	exercise the BitStreamReader and BitStreamWriter a bit
        $writer = new BitStreamWriter();
        foreach ($array as $bit) {
            $writer->writeBit($bit);
        }

        $reader = new BitStreamReader($writer->getData());
        foreach ($array as $bit) {
            $this->assertEquals($bit, $reader->readBit());
        }
    }
}