<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\FakeData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class GameController extends AbstractController
{
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $gameRepo = $entityManager->getRepository(Game::class);
        $games = $gameRepo->findAll();
        return $this->render("game/index.html.twig", ["games" => $games]);

    }

    public function add(Request $request,EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $game = (new Game)
                ->setName($request->request->get("name"))
                ->setImage($request->request->get("image"));
            $entityManager->persist($game);
            $entityManager->flush();
            return $this->redirectTo("/game");
        }
        return $this->render("game/form.html.twig",['player'=>new Game()]);
    }

    public function show($id,EntityManagerInterface $entityManager): Response
    {
        $gameRepo=$entityManager->getRepository(Game::class);
        $game=$gameRepo->find($id);

        return $this->render("game/show.html.twig", ["game" => $game]);
    }

    public function edit($id, Request $request,EntityManagerInterface $entityManager): Response
    {
        $gameRepo=$entityManager->getRepository(Game::class);
        $game = $gameRepo->find($id);
        if ($request->getMethod() == Request::METHOD_POST) {
                $game->setName($request->get("name"))
                    ->setImage($request->get("image"));
            $entityManager->flush();
            return $this->redirectTo("/game");
        }
        return $this->render("game/form.html.twig", ["game" => $game]);
    }

    public function delete($id,EntityManagerInterface $entityManager): Response
    {
        $gameRepo = $entityManager->getRepository(Game::class);
        $game=$gameRepo->find($id);
        $entityManager->remove($game);
        $entityManager->flush();
        return $this->redirectTo("/game");
    }
}