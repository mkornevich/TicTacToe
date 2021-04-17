<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:36
 */

namespace App\Handlers;


use App\App;
use App\Handler;
use App\Helper;
use App\Sync\PartySync;

class Handler_parties_joinParty extends Handler
{

    protected function handle($options)
    {
        $id = $options['id'];
        $party = App::$partyDao->find(function($party) use ($id) {
            return $party->id == $id;
        })[0];

        $this->client->party = $party;
        $party->player2 = $this->client;
        $party->state = 'waitingStep';

        Helper::nextScreenAndState($this->client, 'gameScreen', 'game');
        Helper::updateGameState($party->player1, $party);
        Helper::updateGameState($party->player2, $party);
        PartySync::syncPartiesWithClients();
    }
    protected function validate($options)
    {
        $this->ifError($this->client->state != 'parties', str('err_client_state'));

        $id = $options['id'];
        $partyExist = count(App::$partyDao->find(function($party) use ($id) {
            return $party->id == $id;
        })) == 1;
        $this->ifError(!$partyExist, str('err_party_with_id_not_exist'));
    }

}