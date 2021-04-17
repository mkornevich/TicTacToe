<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:18
 */

namespace App\Handlers;


use App\Handler;
use App\Helper;
use App\Sync\TagSync;

class Handler_parties_startCreateNewParty extends  Handler
{
    function handle($options)
    {
        Helper::nextScreenAndState($this->client, 'createPartyScreen', 'createParty');
        TagSync::syncSuggestionsWithClient($this->client);
    }
}