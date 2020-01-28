<?php

namespace App\Controller;


use App\Entity\Game;
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
        return $this->render("game/index", ["games" => $games]);

    }

    public function add(Request $request,EntityManagerInterface $entityManager): Response
    {
        $game = FakeData::games(1)[0];

        if ($request->getMethod() == Request::METHOD_POST) {
            $game = new Game($request->request->get("name"),$request->request->get("image"));
            $entityManager->persist($game);
            $entityManager->flush();
            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game]);
    }


    public function show($id,EntityManagerInterface $entityManager): Response
    {
        //$game = FakeData::games(1)[0];
        $gameRepo=$entityManager->getRepository(Game::class);
        $game=$gameRepo->find($id);

        return $this->render("game/show", ["game" => $game]);
    }


    public function edit($id, Request $request,EntityManagerInterface $entityManager): Response
    {
        $game = FakeData::games(1)[0];

        if ($request->getMethod() == Request::METHOD_POST) {
            $gameRepo=$entityManager->getRepository(Game::class);
            $gameRepo->find($id)
                ->setName($request->get("name"))
                ->setImage($request->get("image"));
            $entityManager->flush();
            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game]);


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