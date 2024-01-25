<?php

namespace App\Controllers;

use Anvts\Framework\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        $content = "<h1>Post #$id</h1><br><a href='/'>Go to /</a>";
        return new Response($content);
    }
}