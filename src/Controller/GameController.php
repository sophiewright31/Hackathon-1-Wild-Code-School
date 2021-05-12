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
        $newId=100;
        if ($_SESSION['unlockmove']=== 0) {
            $gameDealer = new Gamedealer();
            $gameDealer->init();
            $_SESSION['unlockmove']=1;
            $newId=4;
        }
        $characterManager = new CharacterManager();
        $characters = $characterManager->meet();
        $speakingLover = $gameDealer->checkCurrentPosition($_SESSION['currentPosition']);
        $gameDealer->getSpeech();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $robotMover = new RobotMover();
            $robotMover->move();
            $this->twig->addGlobal('session', $_SESSION);

            $mapManager = new MapManager();
            $newId = $mapManager->getDivIdByCoordinates($_SESSION['currentx'], $_SESSION['currenty']);
            $_SESSION['currentPosition'] = $newId;
            $this->twig->addGlobal('session', $_SESSION);
        }

        return $this->twig->render('Game/index.html.twig', [
            'characters' => $characters,
            'newId' => $newId,
            'speakingLover' =>$speakingLover

        ]);
    }
}
