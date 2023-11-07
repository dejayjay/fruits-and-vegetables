<?php

namespace App\Tests\App\Service;

use PHPUnit\Framework\TestCase;
use App\Service\Item\VegetableCollectionService;

class VegetableCollectionServiceTest extends TestCase
{
    private readonly array $fruit;

    public function setUp(): void
    {
        $this->fruit = [
            'id' => 1,
            'name' => 'Carrot',
            'quantity' => 10922,
            'unit' => 'g'
        ];
    }

    public function testAddingItemsToCollection(): void
    {
        $vegetableCollectionService = new VegetableCollectionService();

        $vegetableCollectionService->add(
            $this->fruit['id'],
            $this->fruit['name'],
            $this->fruit['quantity'],
            $this->fruit['unit']
        );

        $list = $vegetableCollectionService->list();

        $this->assertCount(1, $list);

        $collectionItem = $this->fruit;
        unset($collectionItem['id']);
        unset($collectionItem['unit']);

        $this->assertEqualsCanonicalizing($list[$this->fruit['id']], $collectionItem);
    }

    public function testRemovingItemsFromCollection(): void
    {
        $vegetableCollectionService = new VegetableCollectionService();

        $vegetableCollectionService->add(
            $this->fruit['id'],
            $this->fruit['name'],
            $this->fruit['quantity'],
            $this->fruit['unit']
        );

        $vegetableCollectionService->remove($this->fruit['id']);

        $list = $vegetableCollectionService->list();

        $this->assertCount(0, $list);
    }
}
