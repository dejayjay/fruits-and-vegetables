<?php

namespace App\Service\Item;

use Exception;
use App\Enum\ItemType;
use App\Service\Item\CollectionHandler;
use App\Service\Item\AbstractFactory\FruitFactory;
use App\Service\Item\AbstractFactory\VegetableFactory;

class FactoryCollection
{
    public function __construct(private CollectionHandler $collectionHandler)
    {
    }

    public function handle(array $data): void
    {
        switch ($data['type']) {
            case ItemType::FRUIT->value:
                $this->collectionHandler->handle(new FruitFactory(), $data);
                break;
            case ItemType::VEGETABLE->value:
                $this->collectionHandler->handle(new VegetableFactory(), $data);
                break;
            default:
                throw new Exception('Item type not supported');
        }
    }

    public function getCollections(): array
    {
        return $this->collectionHandler->getCollections();
    }
}
