<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 15:06
 */

namespace App;


use App\Entities\Client;
use App\Entities\Party;

class Helper
{
    public static function updateGameState(Client $client, Party $party) {
        $client->send('gameScreen.updateState', [
            'state' => $party->state,
            'win' => $party->gameField->getWinStatus(),
            'field' => $party->gameField->field,
            'you' => $party->getKeyByPlayer($client),
            'whoStep' => $party->whoStep,
            'player1' => $party->player1 == null ? false : $party->player1->name,
            'player2' => $party->player2 == null ? false : $party->player2->name
        ]);
    }

    public static function nextScreen(Client $client, $screenName, $hidePrev = true) {
        $client->send('screensController.showScreen', [
            'screenName' => $screenName,
            'hidePrev' => $hidePrev
        ]);
    }

    public static function nextScreenAndState(Client $client, $screen, $state) {
        self::nextScreen($client, $screen);
        $client->state = $state;
    }
}