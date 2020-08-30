<?php

namespace App\Service;

use App\Dto\ReviewOvertimeCollection;
use App\Dto\ReviewOvertimeOutput;
use App\Repository\ReviewRepository;
use DateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReviewService
{
    private $reviewRepository;
    private $genericService;
    private $limits;

    /**
     * construct
     * @param ReviewRepository $reviewRepository        review repository
     * @param GenericService $genericService            generic service
     * @param ContainerInterface $container             container
     */
    public function __construct(
        ReviewRepository $reviewRepository,
        GenericService $genericService,
        ContainerInterface $container
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->genericService = $genericService;
        $this->limits = [
            'DATE' => $container->getParameter('app.daily_limit'),
            'WEEK' => $container->getParameter('app.weekly_limit'),
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
        $fromDateValid = $this->genericService->validateDate($fromDateString);
        $reviewOvertimeColl = new ReviewOvertimeCollection();
        if (!$fromDateValid) {
            $reviewOvertimeColl->valid = false;
            $reviewOvertimeColl->errorMessage = "The from date is not valid";
            return $reviewOvertimeColl;
        }

        $toDateValid = $this->genericService->validateDate($toDateString);
        if (!$toDateValid) {
            $reviewOvertimeColl->valid = false;
            $reviewOvertimeColl->errorMessage = "The to date is not valid";
            return $reviewOvertimeColl;
        }

        return $this->getAllGroupedReviews($hotelId, $fromDateString, $toDateString);
    }

    /**
     * get all grouped reviews
     * @param int $hotelId                  hotel id
     * @param stirng $fromDateString        from date string
     * @param string $toDateString          to date string
     * @return array
     */
    private function getAllGroupedReviews(
        $hotelId,
        $fromDateString,
        $toDateString
    ) {
        $fromDate = DateTime::createFromFormat('Y-m-d', $fromDateString);
        $toDate =  DateTime::createFromFormat('Y-m-d', $toDateString);
        $reviews = new ReviewOvertimeCollection();
        $break = false;
        $toLimit = null;
        $fromLimit = $fromDate;
        foreach ($this->limits as $groupBy => $days) {
            if ($toLimit) {
                $fromLimit = $this->genericService->addDays($toLimit, 1);
            }

            if ($days) {
                $toLimit = $this->genericService->addDays($fromDate, $days);
                if ($toLimit > $toDate) {
                    $toLimit = $toDate;
                    $break = true;
                }
            } else {
                $toLimit = null;
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
            $reviewOvertimeOutput->averageScore = $values['sumScore'] / $values['reviewCount'];
            $reviewOvertimeOutput->reviewCount = $values['reviewCount'];
        }

        $reviewOvertimeOutput->dateGroup = isset($values['datePeriod']) ?
            $values['datePeriod'] : (isset($values['weekPeriod']) ?
                $values['weekPeriod'] . ' ' . $values['yearPeriod'] : (isset($values['monthPeriod']) ?
                    $values['monthPeriod'] . '-' . $values['yearPeriod'] : ''));
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