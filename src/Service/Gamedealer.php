<?php

namespace App\Service;

use App\Model\CharacterManager;

class Gamedealer
{
    public const DIV_ID_HOME = 4;
    public function init()
    {
        $characterManager = new CharacterManager();
        for ($idCharacter = 1; $idCharacter <= 39; $idCharacter++) {
                $divIdLocation = rand(1, 40);
            if ($divIdLocation === self::DIV_ID_HOME) {
                $divIdLocation = rand(1, 40);
            }
            $characterManager->insertLocation($idCharacter, $divIdLocation);
        }
    }
}
