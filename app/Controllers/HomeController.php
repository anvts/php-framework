<?php

namespace App\Controllers;

use Anvts\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = '<h1>Home</h1>';
        return new Response($content);
    }
}