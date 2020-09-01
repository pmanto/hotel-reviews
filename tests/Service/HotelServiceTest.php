<?php
// tests/Service/HotelService.php
namespace App\Tests\Service;

use App\Dto\DropDownOutput;
use App\Entity\Hotel;
use App\Repository\HotelRepository;
use App\Service\HotelService;
use PHPUnit\Framework\TestCase;

class HotelServiceTest extends TestCase
{
    private $hotelService;

    private function setData($hotels = [])
    {
        $hotelRepository = $this->createMock(HotelRepository::class);
        $hotelRepository->expects($this->any())
            ->method('findAll')->willReturn($hotels);
        $this->hotelService = new HotelService($hotelRepository);
    }

    /**
     * should map the hotel entity to the DropDownOutput dto object
     */
    public function testHotelToDropDownOutput()
    {
        $this->setData();
        $hotel = new Hotel();
        $hotel->setName('Hotel 1')->setId(1);
        $dto = $this->hotelService->hotelToDropDownOutput($hotel);
        $this->assertInstanceOf(DropDownOutput::class, $dto);
        $this->assertEquals(1, $dto->value);
        $this->assertEquals('Hotel 1', $dto->description);
    }

    /**
     * test getHotelsDropDown without hotels
     * shpuld return empty array
     */
    public function testGetHotelsDropDownWithoutHotels()
    {
        $this->setData();
        $result = $this->hotelService->getHotelsDropDown();
        $this->assertEmpty($result);
    }

    /**
     * test getHotelsDropDown with hotels
     * shpuld return mapped hotels
     */
    public function testGetHotelsDropDownWithHotels()
    {
        $hotel1 = new Hotel();
        $hotel1->setId(1)->setName('Hotel 1');
        $hotel2 = new Hotel();
        $hotel2->setId(2)->setName('Hotel 2');
        $this->setData([$hotel1, $hotel2]);
        $result = $this->hotelService->getHotelsDropDown();
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]->value);
        $this->assertEquals(2, $result[1]->value);
    }
}
