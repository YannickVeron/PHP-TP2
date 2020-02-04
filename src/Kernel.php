<?php

namespace App;

use App\Controller\AbstractController;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class Kernel
{
    private bool $cacheIsEnabled = true;
    private bool $devIsEnabled = true;
    private $request = null;
    private $entityManager = null;
    private ?Router $router = null;

    public function __construct($devIsEnabled = true, $cacheIsEnabled = false)
    {
        $this->cacheIsEnabled = $cacheIsEnabled;
        $this->devIsEnabled = $devIsEnabled;
        $this->request = Request::createFromGlobals();
        $this->entityManager = $this->buildEntityManager();
    }

    private function getDirCache()
    {
        return __DIR__ . "/../var/cache";
    }

    public function run()
    {
        $this->router = new Router(
            new AnnotationDirectoryLoader(
                new FileLocator(__DIR__ . '/Controller/'),
                new AnnotatedRouteControllerLoader(new AnnotationReader())
            ),
            __DIR__ . "/Controller",
            $this->cacheIsEnabled ? ["cache_dir" => $this->getDirCache() . "/router"] : []
        );
        $response = $this->route($this->request);
        $response->send();

    }

    private function buildEntityManager(): EntityManager
    {
        $config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__ . "/Entity"),
            $this->devIsEnabled,
            $this->cacheIsEnabled ? $this->getDirCache() . "/proxy" : null,
            $this->cacheIsEnabled ? new FilesystemCache($this->getDirCache() . "/doctrine") : null,
            false
        );
        // Create a simple "default" Doctrine ORM configuration for Annotations

        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../db.sqlite',
        );

        // obtaining the entity manager
        return EntityManager::create($conn, $config);
    }

    public function getEntityManager()
    {
        return $this->entityManager;

    }

    private function route(Request $request): Response
    {
        $context = new RequestContext('/');

// Routing can match routes with incoming requests
        try {
            $parameters = $this->router->match($request->getPathInfo());
        } catch (ResourceNotFoundException $notFoundException) {
            return new Response("Page Not Found", Response::HTTP_NOT_FOUND);
        }
        list($className, $method) = explode("::", $parameters["_controller"]);
        $resolvedArguments = $this->parametersResolver($className, $method, $parameters);
        $controller = new $className();
        if ($controller instanceof AbstractController) {
            $controller->setRouter($this->router);
        }
        return call_user_func_array([$controller, $method], $resolvedArguments);
    }

    private function parametersResolver($className, $method, $routerParameters = []): array
    {

        try {
            $reflexion = new \ReflectionMethod($className, $method);
        } catch (\ReflectionException $e) {
            return [];
        }

        $params = $reflexion->getParameters();
        $autoInject = [
            Request::class => $this->request,
            EntityManagerInterface::class => $this->entityManager,
        ];
        $paramValues = [];
        foreach ($params as $param) {
            if ($param->hasType() && isset($autoInject[$param->getType()->getName()])) {
                $paramValues[$param->getPosition()] = $autoInject[$param->getType()->getName()];
            } else {
                $paramValues[$param->getPosition()] = $routerParameters[$param->getName()];
            }
        }

        return $paramValues;
    }
}