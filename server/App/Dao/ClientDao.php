<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:34
 */

namespace App\Dao;


use App\Entities\Client;
use Closure;
use Ratchet\ConnectionInterface;

class ClientDao
{

    private $newId = 1;

    /**
     * @var \SplObjectStorage
     */
    private $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function add(Client $client)
    {
        $client->id = $this->newId++;
        $this->clients->attach($client);
    }

    public function remove(Client $client) {
        $this->clients->detach($client);
    }

    /**
     * @param Closure $callback
     * @return Client[]
     */
    public function find(Closure $callback)
    {
        $clients = [];
        foreach ($this->clients as $client) {
            $select = $callback($client);
            if ($select) {
                $clients[] = $client;
            }
        }
        return $clients;
    }

    /**
     * @param ConnectionInterface $connection
     * @return null|Client
     */
    public function getByConnection(ConnectionInterface $connection)
    {
        foreach ($this->clients as $client) {
            if ($client->connection == $connection) {
                return $client;
            }
        }
        return null;
    }
}