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
        return $this->twig->render('Game/index.html.twig');
    }
}
