<?php

namespace App\Service;

use App\Service\Item\FactoryCollection;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidatorException;

class StorageService
{
    protected string $request = '';
    protected FactoryCollection $factoryCollection;
    protected array $collections = [];

    public function __construct(
        string $request,
        FactoryCollection $factoryCollection
    )
    {
        $this->request = $request;
        $this->factoryCollection = $factoryCollection;
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

        foreach($requestArray as $item) {
            $this->validateRequestItem($item);

            $collection = $this->factoryCollection->getCollection($item['type']);
            $collection->add(
                $item['id'],
                $item['name'],
                $item['quantity'],
                $item['unit']
            );
        }
    }

    public function getCollections(): array
    {
        return $this->factoryCollection->getCollections();
    }

    public function validateRequestItem(array $item): void
    {
        $validator = Validation::createValidator();

        $constraint = new Collection([
            'id' => new Constraints\Type(['type' => 'integer']),
            'name' => new Constraints\Type(['type' => 'string']),
            'quantity' => new Constraints\Type(['type' => 'integer']),
            'type' => new Constraints\Choice(['choices' => ['fruit', 'vegetable']]),
            'unit' => new Constraints\Choice(['choices' => ['kg', 'g']])
        ]);
        
        $errors = $validator->validate($item, $constraint);
        
        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            
            throw new ValidatorException(implode('; ', $errorMessages));        }
    }
}
