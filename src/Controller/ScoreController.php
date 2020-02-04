<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Score;
use App\FakeData;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class ScoreController extends AbstractController
{
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $scoreRepo=$entityManager->getRepository(Score::class);
        $gameRepo=$entityManager->getRepository(Game::class);
        $playerRepo=$entityManager->getRepository(Player::class);
        $scores=$scoreRepo->findAll();
        $games=$gameRepo->findAll();
        $players=$playerRepo->findAll();

        return $this->render("score/index.html.twig", ["scores" => $scores,"games"=>$games,"players"=>$players]);
    }

    public function add(Request $request,EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $gameRepo=$entityManager->getRepository(Game::class);
            $playerRepo=$entityManager->getRepository(Player::class);
            $owner = $playerRepo->find($request->get("player"));
            $game = $gameRepo->find($request->get("game"));
            $score =(new Score($request->get("score"),new DateTime()))
                ->setOwner($owner)
                ->setGame($game);
            $entityManager->persist($score);
            $entityManager->flush();
            return $this->redirectTo("/score");
        }
        return $this->redirectTo("/score");
    }

    public function delete($id,EntityManagerInterface $entityManager): Response
    {
        $scoreRepo = $entityManager->getRepository(Score::class);
        $score=$scoreRepo->find($id);
        $entityManager->remove($score);
        $entityManager->flush();
        return $this->redirectTo("/score");
    }

}