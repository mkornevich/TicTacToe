<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:30
 */

namespace App\Entities;


use App\GameField;

class Party
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $state = 'waitingJoin';

    /**
     * @var string
     */
    public $whoStep = 'player1';

    /**
     * @var string[]
     */
    public $tags;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Client
     */
    public $player1;

    /**
     * @var Client
     */
    public $player2;

    /**
     * @var GameField
     */
    public $gameField;

    public function __construct()
    {
        $this->gameField = new GameField();
    }

    public function getOppositePlayer(Client $client) {
        if ($client === $this->player1) {
            return $this->player2;
        }
        if ($client === $this->player2) {
            return $this->player1;
        }
        return null;
    }

    public function getKeyByPlayer(Client $client) {
        if ($client === $this->player1) {
            return 'player1';
        }
        if ($client === $this->player2) {
            return 'player2';
        }
        return null;
    }

    public function getPlayerSign(Client $client) {
        if ($client === $this->player1) {
            return 'x';
        }
        if ($client === $this->player2) {
            return 'o';
        }
        return null;
    }

}