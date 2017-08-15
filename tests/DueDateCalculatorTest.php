<?php
/**
 * Created by PhpStorm.
 * User: smatyas
 * Date: 2017.08.15.
 * Time: 18:45
 */

namespace Smatyas\Ddc\Tests;

use Smatyas\Ddc\DueDateCalculator;
use PHPUnit\Framework\TestCase;

class DueDateCalculatorTest extends TestCase
{
    public function invalidTurnaroundTimeDataProvider()
    {
        return [
            [null],
            ['1'],
            [1.2],
            [[]]
        ];
    }

    /**
     * @dataProvider invalidTurnaroundTimeDataProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The turnaroundTime parameter must be a positive integer.
     */
    public function testInvalidTurnaroundTime($turnaroudTime)
    {
        $submitDate = new \DateTime();
        DueDateCalculator::calculateDueDate($submitDate, $turnaroudTime);
    }
}
