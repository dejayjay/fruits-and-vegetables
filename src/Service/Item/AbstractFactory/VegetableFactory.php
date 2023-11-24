<?php

namespace App\Service\Item\AbstractFactory;

use App\Entity\Vegetable;
use App\Service\Item\Collection\Collection;
use App\Service\Item\Collection\VegetableCollection;

class VegetableFactory extends AbstractItemFactory {
    public function createEntity(array $data): Vegetable
    {
        return new Vegetable(
            $data['id'],
            $data['name'],
            $this->convertQuantity($data['quantity'], $data['unit'])
        );
    }

    public function createCollection(): Collection
    {
        return new VegetableCollection();
    }
}
