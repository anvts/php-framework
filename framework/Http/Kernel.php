<?php

namespace Anvts\Framework\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        $content = '<h1>Test</h1>';
        return new Response($content);
    }
}