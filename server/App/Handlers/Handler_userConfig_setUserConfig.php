<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:22
 */

namespace App\Handlers;


use App\App;
use App\Handler;
use App\Helper;
use App\Sync\PartySync;
use App\Sync\TagSync;

class Handler_userConfig_setUserConfig extends Handler
{
    function handle($options)
    {
        $this->client->name = $options['name'];
        Helper::nextScreenAndState($this->client, 'partiesScreen', 'parties');
        PartySync::syncPartiesWithClient($this->client);
        TagSync::syncSuggestionsWithClient($this->client);
    }

    protected function validate($options)
    {
        $name = $options['name'];

        $this->ifError($this->client->state != 'userConfig', str('err_client_state'));
        $this->ifError(strlen($name) > 32, str('name_very_long'));
        $this->ifError($name == '', str('err_name_empty'));

        $clientsWithThisName = App::$clientDao->find(function($client) use ($name) {
            return $client->name == $name;
        });
        $this->ifError(count($clientsWithThisName) != 0, str('err_name_is_taken'));
    }
}