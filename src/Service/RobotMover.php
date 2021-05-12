<?php

namespace App\Service;

use App\Model\MapManager;

class RobotMover
{
    public function move($currentPosition, $direction)
    {
        $mapManager = new MapManager();
        $actualCoordinates = $mapManager->getCoordonates($currentPosition);
        $currentxy = $actualCoordinates;
        if (($direction === 'left') && ($actualCoordinates['xcoord'] >= 1)) {
            $currentxy['xcoord'] = $actualCoordinates['xcoord'] - 1;
            $currentxy['ycoord'] = $actualCoordinates['ycoord'];
        }
        if (($direction === 'up') && ($actualCoordinates['ycoord'] >= 1)) {
            $currentxy['xcoord'] = $actualCoordinates['xcoord'];
            $currentxy['ycoord'] = $actualCoordinates['ycoord'] - 1;
        }
        if (($direction === 'right') && ($actualCoordinates['xcoord'] <= 6)) {
            $currentxy['xcoord'] = $actualCoordinates['xcoord'] + 1;
            $currentxy['ycoord'] = $actualCoordinates['ycoord'];
        }
        if (($direction === 'down') && ($actualCoordinates['ycoord'] <= 3)) {
            $currentxy['xcoord'] = $actualCoordinates['xcoord'];
            $currentxy['ycoord'] = $actualCoordinates['ycoord'] + 1;
        }
        return($currentxy);
    }
}
