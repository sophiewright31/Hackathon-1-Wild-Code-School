<?php

namespace App\Controller;

use App\Model\CharacterManager;
use App\Model\MapManager;
use App\Service\Gamedealer;
use App\Service\RobotMover;

class GameController extends AbstractController
{
    public function index()
    {
        $gameDealer = new Gamedealer();
        $newId = 4;
        $openmeet = 1;
        $speakingLover = [];
        $speech = "";

        if ($_SESSION['unlockmove'] === 0) {
            $gameDealer->init();
            $_SESSION['unlockmove'] = 1;
            $newId = 4;
            $openmeet = 0;
        }
        $characterManager = new CharacterManager();
        $characters = $characterManager->meet();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $robotMover = new RobotMover();
            $currentxy = $robotMover->move($_SESSION['currentPosition'], $_POST['direction']);

            $mapManager = new MapManager();
            $newId = $mapManager->getDivIdByCoordinates($currentxy['xcoord'], $currentxy['ycoord']);
            $_SESSION['currentPosition'] = $newId;
            $speakingLover = $gameDealer->checkCurrentPosition($_SESSION['currentPosition']);
            $speech = $gameDealer->getSpeech();
            $this->twig->addGlobal('session', $_SESSION);
        }

        $openmeet = 1;

        return $this->twig->render('Game/index.html.twig', [
            'characters' => $characters,
            'newId' => $newId,
            'speakingLover' => $speakingLover,
            'openmeet' => $openmeet,
            'speech' => $speech
        ]);
    }
}
