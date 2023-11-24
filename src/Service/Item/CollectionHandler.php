<?php

namespace App\Service\Item;

use App\Entity\Item;
use Symfony\Component\Validator\Validation;
use App\Service\Item\AbstractFactory\AbstractItemFactory;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Collection;

class CollectionHandler
{
    protected array $collections = [];

    public function handle(AbstractItemFactory $factory, array $data): void 
    {
        $this->validateItem($data);

        $item = $factory->createEntity($data);

        $this->addItemToCollection($item, $factory);
    }

    public function getCollections(): array
    {
        return $this->collections;
    }

    private function addItemToCollection(Item $item, AbstractItemFactory $factory) : void
    {
        $itemType = $item->getItemType();

        if (!isset($this->collections[$itemType])) {
            $this->collections[$itemType] = $factory->createCollection($item);
        }
        
        $this->collections[$itemType]->add($item);
    }

    private function validateItem(array $item) : void
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

            throw new ValidatorException(implode('; ', $errorMessages));
        }
    }
}
