<?php

namespace App\Service;

use App\Service\Item\FactoryCollection;

class StorageService
{
    protected string $request = '';
    protected FactoryCollection $factoryCollection;
    protected array $collections = [];

    public function __construct(
        FactoryCollection $factoryCollection
    ) {
        $this->factoryCollection = $factoryCollection;
    }

    public function setRequest(string $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getRequestArray(): array
    {
        return json_decode($this->request, true);
    }

    public function processRequest(): void
    {
        $requestArray = $this->getRequestArray();

        foreach($requestArray as $data) {
            $this->factoryCollection->handle($data);
        }
    }

    public function getCollections(): array
    {
        return $this->factoryCollection->getCollections();
    }
}
