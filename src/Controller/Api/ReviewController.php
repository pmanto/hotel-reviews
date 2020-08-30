<?php
namespace App\Controller\Api;

use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @Route("/api/overtime/{hotelId}/{fromDate}/{toDate}", 
     *          requirements={"hotelId"="\d+",
     *                        "fromDate"="\d\d\d\d-\d\d-\d\d",
     *                        "toDate"="\d\d\d\d-\d\d-\d\d"},
     *          methods={"GET"})
     */
    public function hotelOvertimeAction(int $hotelId, $fromDate, $toDate)
    {
        $reviews = $this->reviewService->getOvertime($hotelId, $fromDate, $toDate);
        return $this->json($reviews);
    }
}