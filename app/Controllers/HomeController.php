<?php

namespace App\Controllers;

use Anvts\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = "<h1>Home</h1><br><a href='/posts/1'>Go to /posts/1</a>";
        return new Response($content);
    }
}