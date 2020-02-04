<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player",name="player_index")*
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $playerRepo = $entityManager->getRepository(Player::class);
        $players = $playerRepo->findAll();
        return $this->render("player/index.html.twig", ["players" => $players]);
    }

    /**
     * @Route("/player/add",name="player_add")*
     */
    public function add(Request $request,EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $player = (new Player)
                ->setUsername($request->request->get("username"))
                ->setEmail($request->request->get("email"));
            $entityManager->persist($player);
            $entityManager->flush();
            return $this->redirectTo("/player");
        }
        return $this->render("player/form.html.twig",['player'=>new Player()]);
    }

    /**
     * @Route("/player/{id}",name="player_show")*
     */
    public function show($id,EntityManagerInterface $entityManager): Response
    {
        $playerRepo=$entityManager->getRepository(Player::class);
        $gameRepo=$entityManager->getRepository(Game::class);
        $player=$playerRepo->find($id);
        return $this->render("player/show.html.twig", ["player" => $player, "availableGames" => $gameRepo->findAll()]);
    }

    /**
     * @Route("/player/{id}/edit",name="player_edit")*
     */
    public function edit($id, Request $request,EntityManagerInterface $entityManager): Response
    {
        $playerRepo=$entityManager->getRepository(Player::class);
        $player=$playerRepo->find($id);
        if ($request->getMethod() == Request::METHOD_POST) {
            $player->setUsername($request->get("username"))
                    ->setEmail($request->get("email"));
            $entityManager->flush();
            return $this->redirectTo("/player");
        }
        return $this->render("player/form.html.twig", ["player" => $player]);
    }

    /**
     * @Route("/player/{id}/delete",name="player_delete")*
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $playerRepo = $entityManager->getRepository(Player::class);
        $player=$playerRepo->find($id);
        $entityManager->remove($player);
        $entityManager->flush();
        return $this->redirectTo("/player");

    }

    /**
     * @Route("/player/{id}/addgame",name="player_addgame")*
     */
    public function addgame($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $playerRepo = $entityManager->getRepository(Player::class);
            $gameRepo = $entityManager->getRepository(Game::class);
            $player=$playerRepo->find($id);
            $game = $gameRepo->find($request->request->get("game_id"));
            $player->addGame($game);
            $entityManager->flush();
            return $this->redirectTo("/player");
        }
    }
}