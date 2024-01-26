<?php

use League\Container\Container;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Doctrine\DBAL\Connection;
use Anvts\Framework\Http\Kernel;
use Anvts\Framework\Routing\RouterInterface;
use Anvts\Framework\Routing\Router;
use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Dbal\ConnectionFactory;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');

// Application parameters

$appEnv = $_ENV['APP_ENV'] ?? 'local';
$routes = include BASE_PATH . '/routes/web.php';
$viewsPath = BASE_PATH . '/views';
$databaseUrl = 'pdo-mysql://lemp:lemp@database:3306/lemp?charset=utf8mb4';

// Application services

$container = new Container();

$container->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)
    ->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)
    ->addArgument('twig-loader');

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
    ->addArgument(new StringArgument($databaseUrl));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

return $container;