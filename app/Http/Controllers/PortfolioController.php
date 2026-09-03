<?php

namespace App\Http\Controllers;

use App\Services\PortfolioData;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(private readonly PortfolioData $portfolioData)
    {
    }

    public function index(): View
    {
        return view('pages.home', [
            'portfolio' => $this->portfolioData->all(),
        ]);
    }
}
