<?php
namespace App\Domain;

require_once __DIR__.'/Item.php';

use App\Domain\Item;

class Product implements Item 
{

    public $id;

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->getName()
        ];
    }
}