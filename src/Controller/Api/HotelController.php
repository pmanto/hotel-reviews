<?php
namespace App\Controller\Api;

use App\Service\HotelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    private $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * @Route("/api/hotels", methods={"GET"})
     */
    public function hotelAction()
    {
        $ddHotels = $this->hotelService->getHotelsDropDown();
        return $this->json($ddHotels);
    }
}