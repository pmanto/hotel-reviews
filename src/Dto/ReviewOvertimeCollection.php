<?php
namespace App\Dto;

class ReviewOvertimeCollection
{
    /**
     * @var array
     */
    public $reviewOverviews = [];

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var string
     */
    public $errorMessage;
}