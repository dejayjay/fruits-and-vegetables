<?php

namespace App\Service\Item\Collection;

use Exception;
use App\Entity\Item;
use App\Entity\Fruit;
use App\Service\Item\Collection\Collection;

class FruitCollection extends Collection
{
    public function add(Item $fruit): void
    {
        if (!$fruit instanceof Fruit) {
            throw new Exception('Item is not Fruit');
        }

        parent::add($fruit);
    } 
}
