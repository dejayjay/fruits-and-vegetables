<?php

namespace App\Service\Item\AbstractFactory;

use App\Entity\Item;
use App\Enum\UnitType;
use App\Service\Item\Collection\Collection;

abstract class AbstractItemFactory {
    abstract public function createEntity(array $data): Item;
    abstract public function createCollection(): Collection;
    protected function convertQuantity(int $quantity, string $unit): int
    {
        return $unit == UnitType::KILOGRAM->value ? $quantity * 1000 : $quantity; //TODO: improve consider strategy pattern
    }
}
