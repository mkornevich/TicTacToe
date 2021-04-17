<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:28
 */

namespace App\Entities;


use Ratchet\ConnectionInterface;

class Client
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name = 'empty';

    /**
     * @var string
     */
    public $state = "userConfig"; // userConfig, parties, createParty, game

    /**
     * @val string[]
     */
    public $filterTags;

    /**
     * @var ConnectionInterface
     */
    public $connection;

    /**
     * @var Party
     */
    public $party;

    public function send($event, $options)
    {
        $msg = json_encode([
            'event' => $event,
            'options' => $options
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->connection->send($msg);
    }

}