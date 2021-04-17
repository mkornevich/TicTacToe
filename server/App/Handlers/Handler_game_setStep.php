<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:42
 */

namespace App\Handlers;

use App\Handler;
use App\Helper;

class Handler_game_setStep extends Handler
{
    function handle($options)
    {
        $row = $options['row'];
        $col = $options['col'];

        $party = $this->client->party;
        $party->gameField->field[$row][$col] = $party->getPlayerSign($this->client);

        if($party->gameField->getWinStatus() !== false) {
            $party->state = 'gameFinished';
        }

        $opposite = $party->getOppositePlayer($this->client);
        $party->whoStep = $party->getKeyByPlayer($opposite);

        Helper::updateGameState($party->player1, $party);
        Helper::updateGameState($party->player2, $party);
    }

    protected function validate($options)
    {
        $this->ifError($this->client->state != 'game', str('err_client_state'));
    }
}