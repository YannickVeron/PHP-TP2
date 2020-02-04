<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private Router $router;
    public function render($templateName, $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . "/../../templates");
        $twig = new Environment($loader, [
            'cache' => __DIR__ . "/../../var/cache/",
            'debug' => true,
        ]);
        $function = new \Twig\TwigFunction('path', [$this->router,"generate"]);
        $twig->addFunction($function);

        return new Response($twig->render($templateName, $data));
    }

    public function redirectTo($path){
        return new RedirectResponse($path);
    }

    public function setRouter($router)
    {
        $this->router=$router;
    }

    public function redirectToRoute($route,$parameters=[]){
        $this->redirectTo($this->router->generate($route,$parameters));
    }
}