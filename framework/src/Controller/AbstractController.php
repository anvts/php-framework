<?php

namespace Anvts\Framework\Controller;

use Anvts\Framework\Http\Request;
use Anvts\Framework\Http\Response;
use Psr\Container\ContainerInterface;
use Twig\Environment;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    protected Request $request;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function render(string $view, array $params = [], Response $response = null): Response
    {
        /**
         * @var Environment $twig
         */
        $twig = $this->container->get('twig');

        $content = $twig->render($view, $params);

        $response ??= new Response();
        $response->setContent($content);

        return $response;
    }
}