<?php


namespace App\Service;


use App\Model\MapManager;

class RobotMover
{
    public function move()
    {
        $mapManager = new MapManager();
        $actualCoordinates = $mapManager->getCoordonates($_SESSION['currentPosition']);

        if (($actualCoordinates['xcoord'] >= 0) && ($actualCoordinates['xcoord'] <= 7) &&
            ($actualCoordinates['ycoord'] >= 0) && ($actualCoordinates['ycoord'] <= 5)) {
        }

        if (($_POST['direction'] === 'left') && ($actualCoordinates['xcoord'] >= 1)) {
            $_SESSION['currentx'] = $actualCoordinates['xcoord'] - 1;
            $_SESSION['currenty'] = $actualCoordinates['ycoord'];
        }
        if (($_POST['direction'] === 'up') && ($actualCoordinates['ycoord'] >= 1)) {
            $_SESSION['currentx'] = $actualCoordinates['xcoord'];
            $_SESSION['currenty'] = $actualCoordinates['ycoord'] - 1;
        }
        if (($_POST['direction'] === 'right') && ($actualCoordinates['xcoord'] <= 6)) {
            $_SESSION['currentx'] = $actualCoordinates['xcoord'] + 1;
            $_SESSION['currenty'] = $actualCoordinates['ycoord'];
        }
        if (($_POST['direction'] === 'down') && ($actualCoordinates['ycoord'] <= 3)) {
            $_SESSION['currentx'] = $actualCoordinates['xcoord'];
            $_SESSION['currenty'] = $actualCoordinates['ycoord'] + 1;
        }
    }
}