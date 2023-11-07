<?php

namespace App\Tests\App\Service;

use App\Enum\ItemType;
use App\Service\StorageService;
use PHPUnit\Framework\TestCase;
use App\Service\Item\FactoryCollection;

class StorageServiceTest extends TestCase
{
    protected FactoryCollection $factoryCollection;

    public function setUp(): void
    {
        $this->factoryCollection = new FactoryCollection();
    }

    public function testReceivingRequest(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService($request, $this->factoryCollection);

        $this->assertNotEmpty($storageService->getRequest());
        $this->assertIsString($storageService->getRequest());
    }

    public function testParsingRequest(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService($request, $this->factoryCollection);

        $storageService->processRequest();

        $collections = $storageService->getCollections();
        
        $this->assertCount(10, ($collections[ItemType::FRUIT->value])->list());
        $this->assertCount(10, ($collections[ItemType::VEGETABLE->value])->list());
    }

    public function testParsingRequestAnItemWithGramUnit(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService($request, $this->factoryCollection);

        $storageService->processRequest();

        $collections = $storageService->getCollections();
        
        $this->assertEquals(($collections[ItemType::VEGETABLE->value]->list()[1]), [
            'name' => 'Carrot',
            'quantity' => 10922,
        ]);
    }

    public function testParsingRequestAnItemWithKiloGramUnit(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService($request, $this->factoryCollection);

        $storageService->processRequest();

        $collections = $storageService->getCollections();
        
        $this->assertEquals(($collections[ItemType::FRUIT->value]->list()[2]), [
            'name' => 'Apples',
            'quantity' => 20000,
        ]);
    }
}
