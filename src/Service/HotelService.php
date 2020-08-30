<?php

namespace App\Service;

use App\Dto\DropDownOutput;
use App\Entity\Hotel;
use App\Repository\HotelRepository;
use DateTime;

class HotelService
{
    private $hotelRepository;

    /**
     * construct
     * @param HotelRepository $hotelRepository        hotel repository
     */
    public function __construct(
        HotelRepository $hotelRepository
    ) {
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * map hotel to drop down output object
     * @param Hotel $hotel              hotel object
     * @return DropDownOutput           drop down output
     */
    public function hotelToDropDownOutput(Hotel $hotel)
    {
        $ddOutput = new DropDownOutput();
        $ddOutput->value = $hotel->getId();
        $ddOutput->description = $hotel->getName();
        return $ddOutput;
    }

    /**
     * get all the hotels mapped as drop down object
     * @return array            
     */
    public function getHotelsDropDown()
    {
        $hotels = $this->hotelRepository->findAll();
        return array_map([$this,'hotelToDropDownOutput'], $hotels);
    }
}
