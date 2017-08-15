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
            [[]],
            [0],
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

    public function calculateDueDateDataProvider()
    {
        return [
            ['2017-08-15T10:11:12', 2, '2017-08-15T12:11:12'],
            ['2017-08-15T16:00:00', 1, '2017-08-16T9:00:00'],
            ['2017-08-15T16:30:00', 1, '2017-08-16T9:30:00'],
            ['2017-08-15T16:30:00', 2, '2017-08-16T10:30:00'],
            ['2017-08-15T9:00:00', 8, '2017-08-16T9:00:00'],
            ['2017-08-15T9:00:00', 16, '2017-08-17T9:00:00'],
            ['2017-08-18T12:00:00', 8, '2017-08-21T12:00:00'],
            ['2017-08-18T12:00:00', 16, '2017-08-22T12:00:00'],
            ['2017-08-18T12:00:00', 40, '2017-08-25T12:00:00'],
            ['2017-08-18T12:00:00', 47, '2017-08-28T11:00:00'],
        ];
    }

    /**
     * @dataProvider calculateDueDateDataProvider
     */
    public function testCalculateDueDate($submitDateString, $turnaroundTime, $expectedDateString)
    {
        $submitDate = new \DateTime($submitDateString);
        $expectedDate = new \DateTime($expectedDateString);
        $actualDate = DueDateCalculator::calculateDueDate($submitDate, $turnaroundTime);
        $this->assertEquals($expectedDate, $actualDate);
    }
}
