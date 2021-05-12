<?php

namespace App\Service;

use App\Model\AbstractManager;
use App\Model\CharacterManager;
use App\Model\MapManager;

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
        $_SESSION['currentPosition'] = self::DIV_ID_HOME;

    }

    public function getDistance($xR, $yR, $xL, $yL)
    {
        return sqrt(($xR - $xL) * ($xR - $xL) + ($yR - $yL) * ($yR - $yL)) ;
    }
    public function checkSurround($divIdLocation, $loverMatchId)
    {
        $mapManager = new MapManager();
        $characterManager = new CharacterManager();
        $locationCoordonates = $mapManager->getCoordonates($divIdLocation);
        $caracteristics = $characterManager->getcaracteisticsById($loverMatchId);
        $potentialLovers = $characterManager->potentialMatchingLover(($caracteristics));

        $distances = [];
        foreach ($potentialLovers as $potentialLover) {
            $distances[$potentialLover['id']] = $this->getDistance($locationCoordonates['xcoord'], $locationCoordonates['ycoord'], $potentialLover['xcoord'], $potentialLover['ycoord']);
        }
        $minDistance = (min($distances));

        $idNearest = 0;

        foreach ($distances as $id => $distance) {
            if ($distance === $minDistance) {
                $idNearest = $id;
            }
        }

        return $idNearest;
    }
//    public function checkCurrentPosition($position)
//    {
//        $characterManager = new CharacterManager();
//        $lovers = $characterManager->getLoversByPosition($position);
//        $howManyPeople = count($lovers);
////        switch ($howManyPeople) {
////            case 0 : $this->nothingToSee();break;
////            case 1 : $this->checkIsTheOne();break;
////            default:$this->checkManyPeople();break;
//
////        }
//    }
}
