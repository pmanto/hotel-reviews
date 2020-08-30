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
        return $dateTimeClone->add(new DateInterval('P'.$days.'D'));
    }
}
