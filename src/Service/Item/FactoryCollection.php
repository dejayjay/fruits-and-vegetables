<?php

namespace App\Service\Item;

use App\Enum\ItemType;
use App\Service\Item\AbstractCollectionService;
use Exception;

class FactoryCollection
{
    protected array $collections = [];

    public function getCollection($itemType): AbstractCollectionService
    {
        if (!isset($this->collections[$itemType])) {
            $this->initializeCollection($itemType);
        }

        return $this->collections[$itemType];
    }

    private function initializeCollection($itemType): void
    {
        switch ($itemType) {
            case ItemType::FRUIT->value:
                $this->collections[$itemType] = new FruitCollectionService();
                break;
            case ItemType::VEGETABLE->value:
                $this->collections[$itemType] = new VegetableCollectionService();
                break;
            default:
                throw new Exception('Item type not supported');
        }
    }

    public function getCollections(): array
    {
        return $this->collections;
    }
}
