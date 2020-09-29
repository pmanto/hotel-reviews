<?php
// tests/Service/ReviewServiceTest.php
namespace App\Tests\Service;

use App\Dto\ReviewOvertimeCollection;
use App\Repository\ReviewRepository;
use App\Service\ReviewService;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReviewServiceTest extends TestCase
{
    private $reviewService;

    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $fromDateByDays = new DateTime('2019-01-01 00:00');
        $limitDateByDays = new DateTime('2019-01-30 00:00');
        $fromDateByWeek = new DateTime('2019-01-31 00:00');
        $limitDateByWeek = new DateTime('2019-03-31 00:00');
        $fromDateByMonth = new DateTime('2019-04-01 00:00');
        $limitDateByMonth = new DateTime('2020-01-01 00:00');
        $smallToDate = new DateTime('2019-02-15 00:00');
        $byDate = [
            ['reviewCount' => 5, 'sumScore' => '350', 'datePeriod' => '2019-01-02'],
            ['reviewCount' => 12, 'sumScore' => '980', 'datePeriod' => '2019-01-15'],
        ];
        $byWeekSmall = [
            [
                'reviewCount' => 11, 'sumScore' => '1000', 'weekPeriod' => 7,
                'yearPeriod' => 2019
            ],
            [
                'reviewCount' => 12, 'sumScore' => '1150', 'weekPeriod' => 8,
                'yearPeriod' => 2019
            ]
        ];
        $byWeek = [
            [
                'reviewCount' => 8, 'sumScore' => '700', 'weekPeriod' => 6,
                'yearPeriod' => 2019
            ]
        ];
        $byMonth = [
            [
                'reviewCount' => 7, 'sumScore' => '650', 'monthPeriod' => 5,
                'yearPeriod' => 2019
            ],
            [
                'reviewCount' => 9, 'sumScore' => '750', 'monthPeriod' => 9,
                'yearPeriod' => 2019
            ],
        ];
        $reviewRepository = $this->createMock(ReviewRepository::class);
        $reviewRepository->expects($this->any())->method('getByHotelIdAndDateRange')
            ->willReturnMap([
                [1, $fromDateByDays, $limitDateByDays, 'DATE', $byDate],
                [1, $fromDateByWeek, $limitDateByWeek, 'WEEK', $byWeek],
                [1, $fromDateByMonth, $limitDateByMonth, 'MONTH', $byMonth],
                [1, $fromDateByWeek, $smallToDate, 'WEEK', $byWeekSmall]
            ]);
        
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->any())->method('getParameter')
            ->willReturnMap([['app.daily_limit', '29'], ['app.daily_limit', '89']]);

        $this->reviewService = new ReviewService(
            $reviewRepository,
            $container
        );
    }

    /**
     * test getOvertime with invalid from date format
     * should return ReviewOvertimeCollection with invalid and errormessage
     */
    public function testGetOvertimeWithInvalidFromDate()
    {
        $result = $this->reviewService->getOvertime(1, '2020-13-15', '2020-01-01');
        $this->assertInstanceOf(ReviewOvertimeCollection::class, $result);
        $this->assertFalse($result->valid);
        $this->assertEquals('The from date is not valid', $result->errorMessage);
    }

    /**
     * test getOvertime with invalid to date format
     * should return ReviewOvertimeCollection with invalid and errormessage
     */
    public function testGetOvertimeWithInvalidToDate()
    {
        $result = $this->reviewService->getOvertime(1, '2019-01-01', '2021-13-15');
        $this->assertInstanceOf(ReviewOvertimeCollection::class, $result);
        $this->assertFalse($result->valid);
        $this->assertEquals('The to date is not valid', $result->errorMessage);
    }

    /**
     * test getOvertime with toDate smaller than fromDate
     * should return ReviewOvertimeCollection with invalid and errormessage
     */
    public function testGetOvertimeWithToDateSmallerThanFromDate()
    {
        $result = $this->reviewService->getOvertime(1, '2020-01-01', '2019-01-01');
        $this->assertInstanceOf(ReviewOvertimeCollection::class, $result);
        $this->assertFalse($result->valid);
        $this->assertEquals('From date is bigger than to date', $result->errorMessage);
    }
}
