<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:57
 */

namespace App;


class GameField
{
    const ROWS = 10;
    const COLS = 10;
    const REP_COUNT = 5;

    public $field = [];

    public function __construct()
    {
        $this->initField();
    }

    private function initField()
    {
        for ($row = 0; $row < self::ROWS; $row++) {
            $this->field[] = [];
            for ($col = 0; $col < self::COLS; $col++) {
                $this->field[$row][] = '';
            }
        }

    }

    public function getWinStatus()
    {
        for ($row = 0; $row <= self::ROWS - self::REP_COUNT; $row++) {
            for ($col = 0; $col <= self::COLS - self::REP_COUNT; $col++) {

                $sign = $this->field[$row][$col];
                if ($sign == '') continue;

                $directions = [
                    'right' => true,
                    'bottom' => true,
                    'right-bottom' => true,
                ];

                for ($offset = 0; $offset < self::REP_COUNT; $offset++) {
                    if ($this->field[$row][$col + $offset] != $sign) $directions['right'] = false;
                    if ($this->field[$row + $offset][$col] != $sign) $directions['bottom'] = false;
                    if ($this->field[$row + $offset][$col + $offset] != $sign) $directions['right-bottom'] = false;
                }

                $winDirection = false;
                foreach ($directions as $currDirection => $win) {
                    if ($win) {
                        $winDirection = $currDirection;
                        break;
                    }
                }

                if ($winDirection === false) continue;

                return [
                    'row' => $row,
                    'col' => $col,
                    'direction' => $winDirection,
                ];
            }
        }
        return false;
    }
}