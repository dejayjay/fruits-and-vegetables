<?php

namespace App\Tests\App\Service;

use PHPUnit\Framework\TestCase;
use App\Service\Item\FruitCollectionService;

class FruitCollectionServiceTest extends TestCase
{
    private readonly array $fruit;

    public function setUp(): void
    {
        $this->fruit = [
            'id' => 1,
            'name' => 'Apple',
            'quantity' => 10922,
            'unit' => 'g'
        ];
    }

    public function testAddingItemsToCollection(): void
    {
        $fruitCollectionService = new FruitCollectionService();

        $fruitCollectionService->add(
            $this->fruit['id'],
            $this->fruit['name'],
            $this->fruit['quantity'],
            $this->fruit['unit']
        );

        $list = $fruitCollectionService->list();

        $this->assertCount(1, $list);

        $collectionItem = $this->fruit;
        unset($collectionItem['id']);
        unset($collectionItem['unit']);

        $this->assertEqualsCanonicalizing($list[$this->fruit['id']], $collectionItem);
    }

    public function testRemovingItemsFromCollection(): void
    {
        $fruitCollectionService = new FruitCollectionService();

        $fruitCollectionService->add(
            $this->fruit['id'],
            $this->fruit['name'],
            $this->fruit['quantity'],
            $this->fruit['unit']
        );

        $fruitCollectionService->remove($this->fruit['id']);

        $list = $fruitCollectionService->list();

        $this->assertCount(0, $list);
    }
}
