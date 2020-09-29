<?php

namespace App\Service;

use App\Dto\ReviewOvertimeCollection;
use App\Dto\ReviewOvertimeOutput;
use App\Repository\ReviewRepository;
use App\Service\Helper\DateTimeHelper;
use DateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReviewService
{
    private $reviewRepository;
    private $limits;

    /**
     * construct
     * @param ReviewRepository $reviewRepository        review repository
     * @param ContainerInterface $container             container
     */
    public function __construct(
        ReviewRepository $reviewRepository,
        ContainerInterface $container
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->limits = [
            'DATE' => intval($container->getParameter('app.daily_limit')),
            'WEEK' => intval($container->getParameter('app.weekly_limit')),
            'MONTH' => null
        ];
    }

    /**
     * get overtime 
     * @param int $hotelId                  hotel id 
     * @param string $fromDateString        from date yyyy-mm-dd
     * @param string $toDateString          to date yyyy-mm-dd
     * @return ReviewOvertimeCollection     dto object
     */
    public function getOvertime($hotelId, $fromDateString, $toDateString)
    {
        $fromDateValid = DateTimeHelper::validateDate($fromDateString);
        $reviewOvertimeColl = new ReviewOvertimeCollection();
        if (!$fromDateValid) {
            $reviewOvertimeColl->valid = false;
            $reviewOvertimeColl->errorMessage = "The from date is not valid";
            return $reviewOvertimeColl;
        }

        $toDateValid = DateTimeHelper::validateDate($toDateString);
        if (!$toDateValid) {
            $reviewOvertimeColl->valid = false;
            $reviewOvertimeColl->errorMessage = "The to date is not valid";
            return $reviewOvertimeColl;
        }

        $fromDate = new DateTime($fromDateString.' 00:00');
        $toDate =  new DateTime($toDateString.' 00:00');
        if ($fromDate > $toDate) {
            $reviewOvertimeColl->valid = false;
            $reviewOvertimeColl->errorMessage = "From date is bigger than to date";
            return $reviewOvertimeColl;
        }

        return $this->getAllGroupedReviews($hotelId, $fromDate, $toDate);
    }

    /**
     * get all grouped reviews
     * @param int $hotelId                      hotel id
     * @param DateTime $fromDateString        from date string
     * @param DateTime $toDateString          to date string
     * @return array
     */
    private function getAllGroupedReviews(
        int $hotelId,
        DateTime $fromDate,
        DateTime $toDate
    ) {
        $reviews = new ReviewOvertimeCollection();
        $break = false;
        $toLimit = null;
        $fromLimit = $fromDate;
        foreach ($this->limits as $groupBy => $days) {
            if ($toLimit) {
                $fromLimit = DateTimeHelper::addDays($toLimit, 1);
            }

            if ($days) {
                $toLimit = DateTimeHelper::addDays($fromDate, $days);
                if ($toLimit > $toDate) {
                    $toLimit = $toDate;
                    $break = true;
                }
            } else {
                $toLimit = $toDate;
            }

            $result = $this->reviewRepository
                ->getByHotelIdAndDateRange(
                    $hotelId,
                    $fromLimit,
                    $toLimit,
                    $groupBy
                );
            $this->mapOutputCollection($reviews, $result);
            if ($break) {
                break;
            }
        }

        return $reviews;
    }

    /**
     * map output values
     * @param ReviewOvertimeOutput &$reviewOvertimeOutput       review overtime object
     * @param array $values                                     values array
     */
    private function mapOutputValues(ReviewOvertimeOutput &$reviewOvertimeOutput, array $values)
    {
        if (
            isset($values['sumScore']) && isset($values['reviewCount'])
            && $values['reviewCount'] > 0
        ) {
            $reviewOvertimeOutput->averageScore = round($values['sumScore'] / $values['reviewCount'], 1);
            $reviewOvertimeOutput->reviewCount = $values['reviewCount'];
        }

        $reviewOvertimeOutput->dateGroup = isset($values['datePeriod']) ?
            $values['datePeriod'] : (isset($values['weekPeriod']) ?
                $values['weekPeriod'] : (isset($values['monthPeriod']) ?
                    $values['yearPeriod'] . '-' . $values['monthPeriod'] : ''));

        $reviewOvertimeOutput->period =  isset($values['datePeriod']) ?
            (new DateTime($values['datePeriod']))->format('Y-m') : (isset($values['weekPeriod']) ?
                DateTimeHelper::getDateFromWeek($values['yearPeriod'], $values['weekPeriod']) :
                DateTimeHelper::getDateFromMonth($values['yearPeriod'], $values['monthPeriod']));
    }

    /**
     * map output collection
     * @param ReviewOvertimeCollection &$reviewOvertimeColl                     review overtime collection
     * @param array $collection                                                 data
     */
    private function mapOutputCollection(
        ReviewOvertimeCollection &$reviewOvertimeColl,
        array $collection
    ) {
        foreach ($collection as $row) {
            $temp = new ReviewOvertimeOutput();
            $this->mapOutputValues($temp, $row);
            $reviewOvertimeColl->reviewOverviews[] = $temp;
        }
    }
}
