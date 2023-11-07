<?php

namespace App\Service\Item;

use Exception;
use App\Enum\UnitType;

class AbstractCollectionService
{
    protected array $list = [];
    
    public function add(
        int $id,
        string $name,
        int $quantity,
        string $unit
    ): void
    {
        $this->list[$id] = [
            'name' => $name,
            'quantity' => $unit == UnitType::KILOGRAM->value ? $quantity * 1000 : $quantity, //TODO: improve consider strategy pattern
        ];
    }
    
    public function remove(int $id): void
    {
        if (!isset($this->list[$id])) {
            throw new Exception("Id doesn't exist");
        }

        unset($this->list[$id]);
    }
    
    public function list(): array
    {
        return $this->list;
    }
}
