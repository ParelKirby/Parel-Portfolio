<?php

namespace App\Http\Controllers;

use App\Services\PortfolioData;
use Illuminate\Http\JsonResponse;

class PortfolioApiController extends Controller
{
    public function __construct(private readonly PortfolioData $portfolioData)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->portfolioData->all());
    }
}
