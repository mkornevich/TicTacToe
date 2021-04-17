<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 23:44
 */

namespace App\Handlers;


use App\App;
use App\Handler;
use App\Helper;
use App\Sync\PartySync;

class Handler_onCloseConnection extends Handler
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
        App::$clientDao->remove($this->client);
        PartySync::syncPartiesWithClients();
        echo "Close connection: clientId = {$this->client->id}\n";
    }
}