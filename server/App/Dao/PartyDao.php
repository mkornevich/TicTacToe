<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:35
 */

namespace App\Dao;


use App\Entities\Party;
use Closure;

class PartyDao
{
    private $newId = 1;

    /**
     * @var \SplObjectStorage
     */
    private $parties;

    public function __construct()
    {
        $this->parties = new \SplObjectStorage();
    }

    public function add(Party $party)
    {
        $party->id = $this->newId++;
        $this->parties->attach($party);
    }

    public function remove(Party $party)
    {
        $this->parties->detach($party);
    }

    /**
     * @param Closure $callback
     * @return []Party
     */
    public function find(Closure $callback)
    {
        $parties = [];
        foreach ($this->parties as $party) {
            if ($callback($party)) {
                $parties[] = $party;
            }
        }
        return $parties;
    }

    public function all()
    {
        return $this->parties;
    }

}