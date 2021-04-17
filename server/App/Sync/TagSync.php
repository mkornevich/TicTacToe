<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 12:39
 */

namespace App\Sync;

use App\App;
use App\Entities\Client;

class TagSync
{
    public static function syncSuggestionsWithClients()
    {
        $clients = App::$clientDao->find(function ($client) {
            return in_array($client->state, ['parties', 'createParty']);
        });

        foreach ($clients as $client) {
            self::syncSuggestionsWithClient($client);
        }
    }

    /**
     * @param Client $client
     */
    public static function syncSuggestionsWithClient($client)
    {
        if (in_array($client->state, ['parties', 'createParty'])) {
            $client->send( $client->state . 'Screen.setAllTags', [
                'tags' => App::$tagDao->tags
            ]);
        }
    }
}