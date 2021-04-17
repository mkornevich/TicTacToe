<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 20:33
 */

namespace App\Handlers;


use App\Handler;
use App\Sync\PartySync;

class Handler_parties_setFilter extends Handler
{
    function handle($options)
    {
        $this->client->filterTags = $options['tags'];
        PartySync::syncPartiesWithClient($this->client);
    }
}