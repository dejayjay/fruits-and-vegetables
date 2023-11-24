<?php

namespace App\Entity;

use App\Entity\Item;
use App\Enum\ItemType;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VegetableRepository;

#[ORM\Entity(repositoryClass: VegetableRepository::class)]
class Vegetable extends Item
{
    public function getItemType() : string
    {
        return ItemType::VEGETABLE->value;
    }
}
