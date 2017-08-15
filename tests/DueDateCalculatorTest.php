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
    public function testInvalidTurnaroundTime($turnaroundTime)
    {
        $submitDate = new \DateTime();
        DueDateCalculator::calculateDueDate($submitDate, $turnaroundTime);
    }

    public function invalidSubmitDateDataProvider()
    {
        return [
            ['2017-08-15T8:59:59'],
            ['2017-08-15T17:00:01'],
            ['2017-08-19T10:00:00'],
            ['2017-08-20T10:00:00'],
        ];
    }

    /**
     * @dataProvider invalidSubmitDateDataProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The submitDate parameter must be a workday between 9AM and 5PM.
     */
    public function testInvalidSubmitDate($submitDateString)
    {
        $submitDate = new \DateTime($submitDateString);
        DueDateCalculator::calculateDueDate($submitDate, 1);
    }
}
