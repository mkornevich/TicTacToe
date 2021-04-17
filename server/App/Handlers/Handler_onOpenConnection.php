<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2021
 * Time: 1:07
 */

namespace App\Handlers;


use App\App;
use App\Entities\Client;
use App\Handler;

class Handler_onOpenConnection extends Handler
{
    function handle($options)
    {
        $this->client->connection = $options['connection'];
        App::$clientDao->add($this->client);
        echo "New connection: clientId = {$this->client->id}\n";
    }
}