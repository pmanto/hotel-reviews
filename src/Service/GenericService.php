<?php

namespace App\Service;

use DateInterval;
use DateTime;

class GenericService
{
    /**
     * validate string date format
     * @param string $date      formatted date
     * @param string $format    date format
     * @return bool             true if the date is valid
     */
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * add days to a date
     * @param DateTime $dateTime        datetime object
     * @param int $days                 days
     * @return DateTime                 
     */
    function addDays(DateTime $dateTime, int $days)
    {
        $dateTimeClone = clone $dateTime;
        return $dateTimeClone->add(new DateInterval('P' . $days . 'D'));
    }

    /**
     * get date from week
     * @param int $year             year
     * @param int $week             week of the year
     * @return string               month year fromatted
     */
    function getDateFromWeek(int $year, int $week)
    {
        $weekStart = new DateTime();
        $weekStart->setISODate($year, $week);
        return $weekStart->format('Y-m');
    }

    /**
     * get date from month
     * @param int $year                 year
     * @param int $month                month of the year
     * @return string                   month year formatted
     */
    function getDateFromMonth(int $year, int $month)
    {
        $monthStart = new DateTime();
        return $monthStart->setDate($year, $month, 1)->format('Y-m');
    }
}
