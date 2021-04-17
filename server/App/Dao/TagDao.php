<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:35
 */

namespace App\Dao;


class TagDao
{
    /**
     * @var string[]
     */
    public $tags = [];

    public function addOnlyNewTags($tags) {
        foreach ($tags as $tag) {
            if (!in_array($tag, $this->tags)) {
                $this->tags[] = $tag;
            }
        }
    }
}