<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:47
 */

namespace App\Sync;

use App\App;
use App\Entities\Client;
use App\Entities\Party;

class PartySync
{
    public static function syncPartiesWithClients()
    {
        $clients = App::$clientDao->find(function ($client) {
            return $client->state == 'parties';
        });

        foreach ($clients as $client) {
            self::syncPartiesWithClient($client);
        }
    }

    /**
     * @param Client $client
     */
    public static function syncPartiesWithClient($client)
    {
        $parties = self::getPartiesForClient($client);
        $prepared = self::prepareParties($parties);

        $client->send('partiesScreen.setParties', [
            'parties' => $prepared
        ]);
    }

    /**
     * @param Party[] $parties
     * @return array
     */
    private static function prepareParties($parties)
    {
        $prepared = [];
        foreach ($parties as $party) {
            $prepared[] = [
                'id' => $party->id,
                'name' => $party->name,
                'tags' => $party->tags,
                'player1' => $party->player1 == null ? false : $party->player1->name,
                'player2' => $party->player2 == null ? false : $party->player2->name
            ];
        }
        return $prepared;
    }

    private static function getPartiesForClient(Client $client)
    {
        if ($client->filterTags == []) {
            return App::$partyDao->all();
        } else {
            return App::$partyDao->find(function ($party) use ($client) {
                return count(array_intersect($party->tags, $client->filterTags)) == count($client->filterTags);
            });
        }
    }
}