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
    }
}
