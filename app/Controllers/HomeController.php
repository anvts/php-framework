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
        $content = "<h1>Home</h1><br><a href='/posts/1'>Go to /posts/1</a>";
        $content .= "<br><br><a href='{$this->testService->getTestUrl()}'>Link from test service</a>";
        return new Response($content);
    }
}