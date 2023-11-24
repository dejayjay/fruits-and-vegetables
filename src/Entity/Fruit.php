<?php

namespace App\Entity;

use App\Entity\Item;
use App\Enum\ItemType;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FruitRepository;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit extends Item
{
    public function getItemType() : string
    {
        return ItemType::FRUIT->value;
    }
}
