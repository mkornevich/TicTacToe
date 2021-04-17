<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:26
 */

namespace App\Handlers;

use App\App;
use App\Handler;
use App\Helper;
use App\Sync\PartySync;
use App\Sync\TagSync;

class Handler_game_leaveParty extends Handler
{
    function handle($options)
    {
        $party = $this->client->party;

        if ($party != null) {
            $party->state = 'gameFinished';
            $oppositePlayer = $party->getOppositePlayer($this->client);
            if ($oppositePlayer != null) {
                Helper::updateGameState($oppositePlayer, $party);
                $oppositePlayer->party = null;
            }
            $this->client->party = null;
            App::$partyDao->remove($party);
        }

        Helper::nextScreenAndState($this->client, 'partiesScreen', 'parties');
        PartySync::syncPartiesWithClients();
        TagSync::syncSuggestionsWithClient($this->client);
    }

    protected function validate($options)
    {
        $this->ifError($this->client->state != 'game', str('err_client_state'));
    }
}