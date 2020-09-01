<?php
// tests/Service/GenericServiceTest.php
namespace App\Tests\Service;

use App\Service\GenericService;
use DateTime;
use PHPUnit\Framework\TestCase;

class GenericServiceTest extends TestCase
{
    private $genericService;

    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->genericService = new GenericService();
    }

    /**
     * test validateDate with wrong date, should return false
     */
    public function testValidateDateWithWrongDate()
    {
        $result = $this->genericService->validateDate('2020-13-02');
        $this->assertFalse($result);
    }

    /**
     * test validateDate with different format, should return false
     */
    public function testValidateDateWithDifferentFormat()
    {
        $result = $this->genericService->validateDate('2020-12-02', 'd/m/Y');
        $this->assertFalse($result);
    }

    /**
     * test validateDate with valid format, should return true
     */
    public function testValidateDateWithValidFormat()
    {
        $result = $this->genericService->validateDate('2020-12-02');
        $this->assertTrue($result);
    }

    /**
     * test add days with positive days = 2 and date 2020-09-30
     * should return 2020-10-02
     */
    public function testAddDaysAdd()
    {
        $date = new DateTime('2020-09-30');
        $dateResult = new DateTime('2020-10-02');
        $result = $this->genericService->addDays($date, 2);
        $this->assertEquals($dateResult, $result);
    }

    /**
     * test add days with negative days = -2 and date 2020-09-30
     * should return null
     */
    public function testAddDaysSubs()
    {
        $date = new DateTime('2020-09-30');
        $result = $this->genericService->addDays($date, -2);
        $this->assertNull($result);
    }

    /**
     * test getDateFromWeek for 2020 and 2 
     * should return the month and year 2020-01
     */
    public function testGetDateFromWeek()
    {
        $result = $this->genericService->getDateFromWeek(2020,2);
        $this->assertEquals('2020-01', $result);
    }

    /**
     * test getDateFromMonth with invalid month
     * should return 2021-01
     */
    public function testGetDateFromMonthWithInvalidMonth()
    {
        $result = $this->genericService->getDateFromMonth(2020, 13);
        $this->assertEquals('2021-01', $result);
    }

    /**
     * test getDateFromMonth with valid month
     * should return the 2021-01
     */
    public function testGetDateFromMonthWithValidMonth()
    {
        $result = $this->genericService->getDateFromMonth(2021, 1);
        $this->assertEquals('2021-01', $result);
    }
}