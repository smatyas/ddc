<?php
/**
 * Created by PhpStorm.
 * User: smatyas
 * Date: 2017.08.15.
 * Time: 18:36
 */

namespace Smatyas\Ddc;

/**
 * Implements the due date calculator functionality.
 */
class DueDateCalculator
{
    const WORK_HOURS_START = 9;
    const WORK_HOURS_END = 17;

    /**
     * Calculates the due date for the given submit date and turnaround time.
     *
     * @param \DateTime $submitDate The submit date.
     * @param int $turnaroundTime The turnaround time.
     */
    public static function calculateDueDate(\DateTime $submitDate, $turnaroundTime)
    {
        if (!is_int($turnaroundTime) || $turnaroundTime < 0) {
            throw new \InvalidArgumentException('The turnaroundTime parameter must be a positive integer.');
        }

        $dayOfWeek = $submitDate->format('N');
        if ($dayOfWeek > 5) {
            throw new \InvalidArgumentException('The submitDate parameter must be a workday between 9AM and 5PM.');
        }

        $minTime = clone $submitDate;
        $minTime->setTime(static::WORK_HOURS_START, 0);

        $maxTime = clone $submitDate;
        $maxTime->setTime(static::WORK_HOURS_END, 0);

        if ($submitDate < $minTime || $submitDate > $maxTime) {
            throw new \InvalidArgumentException('The submitDate parameter must be a workday between 9AM and 5PM.');
        }
    }
}
