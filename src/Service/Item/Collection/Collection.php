<?php

namespace App\Service\Item\Collection;

use App\Entity\Item;
use Exception;

abstract class Collection
{
    protected array $items = [];

    public function add(Item $item): void
    {
        $this->items[$item->getId()] = $item;
    }

    public function remove(int $id): void
    {
        if (!isset($this->items[$id])) {
            throw new Exception("Id doesn't exist");
        }

        unset($this->items[$id]);
    }

    public function list(): array
    {
        return $this->items;
    }
}
