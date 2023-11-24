<?php

namespace App\Service\Item\Collection;

use Exception;
use App\Entity\Item;
use App\Entity\Vegetable;
use App\Service\Item\Collection\Collection;

class VegetableCollection extends Collection
{
    public function add(Item $vegetable): void
    {
        if (!$vegetable instanceof Vegetable) {
            throw new Exception('Item is not Fruit');
        }

        parent::add($vegetable);
    } 
}
