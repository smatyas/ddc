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
     * @return \DateTime The due date.
     */
    public static function calculateDueDate(\DateTime $submitDate, $turnaroundTime)
    {
        if (!is_int($turnaroundTime) || $turnaroundTime <= 0) {
            throw new \InvalidArgumentException('The turnaroundTime parameter must be a positive integer.');
        }

        if (!self::isWorkingHour($submitDate)) {
            throw new \InvalidArgumentException('The submitDate parameter must be a workday between 9AM and 5PM.');
        }

        $dueDate = self::incrementDueDate(clone $submitDate, $turnaroundTime);

        return $dueDate;
    }

    /**
     * Tells if the given date time is in a working hours interval.
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    private static function isWorkingHour(\DateTime $dateTime)
    {
        $dayOfWeek = (int) $dateTime->format('N');
        if ($dayOfWeek > 5) {
            return false;
        }

        $minTime = clone $dateTime;
        $minTime->setTime(static::WORK_HOURS_START, 0);

        $maxTime = clone $dateTime;
        $maxTime->setTime(static::WORK_HOURS_END, 0);

        if ($dateTime < $minTime || $dateTime >= $maxTime) {
            return false;
        }

        return true;
    }

    /**
     * A recursive function that increments the due date until the turnaround time is not 0.
     *
     * @param \DateTime $dueDate
     * @param $turnaroundTime
     * @return \DateTime
     */
    private static function incrementDueDate(\DateTime $dueDate, $turnaroundTime)
    {
        if ($turnaroundTime === 0) {
            return $dueDate;
        }

        $dueDate->modify('+1 hour');
        if (self::isWorkingHour($dueDate)) {
            $turnaroundTime--;
        }

        return self::incrementDueDate($dueDate, $turnaroundTime);
    }
}
