<?php

namespace App\Service\Helper;

use DateInterval;
use DateTime;

class DateTimeHelper
{
    /**
     * validate string date format
     * @param string $date      formatted date
     * @param string $format    date format
     * @return bool             true if the date is valid
     */
    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * add days to a date
     * @param DateTime $dateTime        datetime object
     * @param int $days                 days
     * @return DateTime|null                 
     */
    public static function addDays(DateTime $dateTime, int $days)
    {
        if ($days > 0) {
            $dateTimeClone = clone $dateTime;
            return $dateTimeClone->add(new DateInterval('P' . $days . 'D'));
        }
        return null;
    }

    /**
     * get date from week
     * @param int $year             year
     * @param int $week             week of the year
     * @return string               month year fromatted
     */
    public static function getDateFromWeek(int $year, int $week)
    {
        $weekStart = new DateTime();
        $weekStart->setISODate($year, $week);
        return $weekStart->format('Y-m');
    }

    /**
     * get date from month formatted instead of 2020-1 return 2020-01
     * @param int $year                 year
     * @param int $month                month of the year
     * @return string                   month year formatted
     */
    public static function getDateFromMonth(int $year, int $month)
    {
        $monthStart = new DateTime();
        return $monthStart->setDate($year, $month, 1)->format('Y-m');
    }
}
