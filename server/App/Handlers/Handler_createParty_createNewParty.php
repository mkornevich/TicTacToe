<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:21
 */

namespace App\Handlers;


use App\App;
use App\Entities\Party;
use App\Handler;
use App\Helper;
use App\Sync\PartySync;
use App\Sync\TagSync;

class Handler_createParty_createNewParty extends Handler
{
    function handle($options)
    {
        App::$tagDao->addOnlyNewTags($options['tags']);

        $party = new Party();
        $party->name = $options['name'];
        $party->tags = $options['tags'];
        $party->player1 = $this->client;
        $party->state = 'waitingJoin';
        App::$partyDao->add($party);

        $this->client->party = $party;

        Helper::nextScreenAndState($this->client, 'gameScreen', 'game');
        Helper::updateGameState($this->client, $party);
        PartySync::syncPartiesWithClients();
        TagSync::syncSuggestionsWithClients();
    }

    protected function validate($options)
    {
        $this->ifError(strlen($options['name']) > 32, str('err_party_name_very_long'));
        $this->ifError(strlen($options['name']) == 0, str('err_party_name_empty'));
    }
}