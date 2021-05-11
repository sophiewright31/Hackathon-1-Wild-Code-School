<?php

namespace App\Controller;

use App\Model\CharacterManager;
use App\Service\Gamedealer;

class GameController extends AbstractController
{
    public function index(): string
    {
        $gameDealer = new Gamedealer();
        $characterManager = new CharacterManager();
        $characters = $characterManager->meet();
        $gameDealer->init();
        $idNearestPotentialLover = $gameDealer->checkSurround(1, $_SESSION['loverMatchId']);
        return $this->twig->render('Game/index.html.twig', [
            'characters' => $characters
        ]);
    }
}
