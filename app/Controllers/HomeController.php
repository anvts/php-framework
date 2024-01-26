<?php

namespace App\Controllers;

use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Http\Response;
use App\Services\TestService;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly TestService $testService,
    )
    {
    }

    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'testUrl' => $this->testService->getTestUrl()
        ]);
    }
}