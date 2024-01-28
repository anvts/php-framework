<?php

namespace App\Controllers;

use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Http\Response;

class HomeController extends AbstractController
{
    public function __construct(
    )
    {
    }

    public function index(): Response
    {
        return $this->render('home.html.twig');
    }
}