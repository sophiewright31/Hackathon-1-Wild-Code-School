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
        $gameDealer->getSpeech();
        $speakingLover = $gameDealer->checkCurrentPosition(5);
        return $this->twig->render('Game/index.html.twig', [
            'speakingLover' =>$speakingLover

        ]);
    }
}
