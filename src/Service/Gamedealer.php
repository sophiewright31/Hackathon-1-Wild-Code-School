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
        $locationCoordonates['ycoord'] ++;
        $locationCoordonates['xcoord'] ++;
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
    public function checkCurrentPosition($position)
    {
        $characterManager = new CharacterManager();
        $lovers = $characterManager->getLoversByPosition($position);
        foreach ($lovers as $lover){
            if($lover['id'] === $_SESSION['loverMatchId']){
                $this->happyEnd();die();
            }
        }
        if(empty($lovers)){
            $loverSpeaking = [];
        }
        else{
            $loverSpeaking = $lovers[0];
        }
        return $loverSpeaking;


    }

    public function getCommonCarac($id1, $id2)
    {
        $result = "";
        $characterManager = new CharacterManager();
        $charac1 = $characterManager->getcaracteisticsById($id1);
        $charac2 = $characterManager->getcaracteisticsById($id2);
        foreach ($charac1[0] as $qualite => $valeur){
            if($valeur === $charac2[0][$qualite]){
                $result =  $qualite;break;
            }
        }
        return $result;
    }
    public function getSpeech(){
//        to erase
        $characterManager = new CharacterManager();
        $speech = "I'm not your lover but i know";
        $character1Id = $_SESSION['loverMatchId'];
        $character2Id = $this->checkSurround($_SESSION['currentPosition'], $_SESSION['loverMatchId'] );
        $commonQualite = $this->getCommonCarac($character1Id,$character2Id);
        $qualité1 = $characterManager->getcaracteisticsById($character1Id)[0];
        switch ($commonQualite){
            case 'species':
                $speech .=" a " . $qualité1['species'];
                break;
            case 'status':
                $speech .=" a " . $qualité1['status'] . ' person ';
                break;
            case 'gender':
                $speech .=" a " . $qualité1['gender'];
                break;
            case 'skill':
                $speech .=" a " . $qualité1['skill'];
                break;
            case 'hair':
                $speech .=" a " . $qualité1['hair'] . ' haired person';
                break;
            case 'skill1':
                $speech .=" a " . $qualité1['skill1'] ;
                break;


        }
                $speech .= " who leaves ";
        $mapManager = new MapManager();
        $area = $mapManager->getAreaByLoverId($character2Id);
        if($area){
            $speech .= ' in ' . $area;
        }else {
            $speech .= ' in a few minutes from here';
        }
        return $speech;

    }

}
