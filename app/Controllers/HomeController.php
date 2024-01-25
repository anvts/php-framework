<?php

namespace App\Controllers;

use Anvts\Framework\Http\Response;
use App\Services\TestService;
use Twig\Environment;

class HomeController
{
    public function __construct(
        private readonly TestService $testService,
        private readonly Environment $twig
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