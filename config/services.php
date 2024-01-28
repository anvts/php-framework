<?php

use League\Container\Container;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\Connection;
use Anvts\Framework\Http\Kernel;
use Anvts\Framework\Routing\RouterInterface;
use Anvts\Framework\Routing\Router;
use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Dbal\ConnectionFactory;
use Anvts\Framework\Cli\Kernel as CliKernel;
use Anvts\Framework\Cli\Application;
use Anvts\Framework\Cli\Commands\MigrateCommand;
use Anvts\Framework\Template\TwigFactory;
use Anvts\Framework\Session\SessionInterface;
use Anvts\Framework\Session\Session;

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

$container->add('framework-cli-commands-namespace', new StringArgument('Anvts\\Framework\\Cli\\Commands\\'));

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->addShared(SessionInterface::class, Session::class);

$container->add('twig-factory', TwigFactory::class)
    ->addArgument(new StringArgument($viewsPath))
    ->addArgument(SessionInterface::class);

$container->addShared('twig', function () use ($container) {
    return $container->get('twig-factory')->create();
});

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
    ->addArgument(new StringArgument($databaseUrl));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

$container->add(CliKernel::class)
    ->addArgument($container)
    ->addArgument(Application::class);

$container->add(Application::class)
    ->addArgument($container);

$container->add('cli:migrate', MigrateCommand::class)
    ->addArgument(Connection::class)
    ->addArgument(new StringArgument(BASE_PATH . '/database/migrations'));

return $container;