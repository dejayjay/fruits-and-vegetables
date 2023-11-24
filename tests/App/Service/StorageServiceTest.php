<?php

namespace App\Tests\App\Service;

use App\Enum\ItemType;
use App\Service\StorageService;
use App\Service\Item\CollectionHandler;
use App\Service\Item\FactoryCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StorageServiceTest extends KernelTestCase
{
    protected FactoryCollection $factoryCollection;
    protected StorageService $storageService;

    public function setUp(): void
    {
        $this->factoryCollection = new FactoryCollection(new CollectionHandler());

        $this->storageService = new StorageService($this->factoryCollection);

        $request = file_get_contents('request.json');

        $this->storageService->setRequest($request);
    }

    public function testReceivingRequest(): void
    {
        $this->assertNotEmpty($this->storageService->getRequest());
        $this->assertIsString($this->storageService->getRequest());
    }

    public function testParsingRequest(): void
    {
        $this->storageService->processRequest();

        $collections = $this->storageService->getCollections();
        
        $this->assertCount(10, ($collections[ItemType::FRUIT->value])->list());
        $this->assertCount(10, ($collections[ItemType::VEGETABLE->value])->list());
    }

    public function testParsingRequestAnItemWithGramUnit(): void
    {
        $this->storageService->processRequest();

        $collections = $this->storageService->getCollections();

        $vegetable = $collections[ItemType::VEGETABLE->value]->list()[1]; 

        $this->assertEquals($vegetable->getName(), 'Carrot');

        $this->assertEquals($vegetable->getQuantity(), 10922);
    }

    public function testParsingRequestAnItemWithKiloGramUnit(): void
    {
        $this->storageService->processRequest();

        $collections = $this->storageService->getCollections();
        
        $fruit = $collections[ItemType::FRUIT->value]->list()[2]; 

        $this->assertEquals($fruit->getName(), 'Apples');

        $this->assertEquals($fruit->getQuantity(), 20000);
    }
}
