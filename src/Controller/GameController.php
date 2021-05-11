<?php

namespace App\Controller;

use App\Model\CharacterManager;
use App\Service\Gamedealer;

class GameController extends AbstractController
{
    public function index()
    {
        $gameDealer = new Gamedealer();
        $gameDealer->init();
        $idNearestPotentialLover = $gameDealer->checkSurround(1, $_SESSION['loverMatchId']);
        return $this->twig->render('Game/index.html.twig');
    }
}
