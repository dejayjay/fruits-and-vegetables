<?php

namespace App\Service\Item\AbstractFactory;

use App\Entity\Fruit;
use App\Service\Item\Collection\Collection;
use App\Service\Item\Collection\FruitCollection;

class FruitFactory extends AbstractItemFactory {
    public function createEntity(array $data): Fruit
    {
        return new Fruit(
            $data['id'],
            $data['name'],
            $this->convertQuantity($data['quantity'], $data['unit'])
        );
    }

    public function createCollection(): Collection
    {
        return new FruitCollection();
    }
}
