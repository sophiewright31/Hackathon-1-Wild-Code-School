<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CharacterManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $matchMessage = "";
        $match = [];
        $characterManager = new characterManager();
        $availableOPtions = $characterManager->selectAvailableOptions();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($characterManager->returnPerfectMatch(($_POST))) {
                $match = $characterManager->returnPerfectMatch(($_POST));
                $matchMessage = "Perfect Match Found";
            } else {
                $match = $characterManager->returnAlternativeMatch(($_POST));
                $matchMessage = "No perfect match found but this person can correspond";
            }
            $_SESSION['loverId'] = $match['id'];
            var_dump($_SESSION['loverId']);
            return $this->twig->render('Home/match.html.twig', ['match' => $match,'matchMessage' => $matchMessage]);
        }
        return $this->twig->render('Home/index.html.twig', ['available_options' => $availableOPtions]);
    }
}
