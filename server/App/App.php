<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:39
 */

namespace App;


use App\Dao\ClientDao;
use App\Dao\PartyDao;
use App\Dao\TagDao;

class App
{
    /**
     * @var ClientDao
     */
    public static $clientDao;

    /**
     * @var TagDao
     */
    public static $tagDao;

    /**
     * @var PartyDao
     */
    public static $partyDao;

    public static function init() {
        self::$clientDao = new ClientDao();
        self::$tagDao = new TagDao();
        self::$partyDao = new PartyDao();
    }
}