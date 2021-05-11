<?php

namespace App\Controller;

use App\Model\CharacterManager;

class GameController extends AbstractController
{
    public function index(): string
    {
        $characterManager = new CharacterManager();
        $characters = $characterManager->meet();
        return $this->twig->render('Game/index.html.twig', [
            'characters' => $characters
        ]);
    }
}
