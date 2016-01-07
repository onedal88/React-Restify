<?php
namespace App\Domain;

require_once __DIR__.'/Item.php';

use App\Domain\Item;

class Storage 
{
    private $itens;

    public function __construct()
    {
        $this->itens = new \ArrayIterator();
    }

    public function insert(Item $item) 
    {   
        $item->id = $this->itens->count() + 1;
        $this->itens->offsetSet($item->id, $item);

        return $item;
    }

    public function remove($id) 
    {   
        if ($this->itens->offsetExists($id)){
            $item = $this->itens->offsetUnset($id);
            return true;
        }
    }

    public function toArray()
    {
        $result = [];

        foreach ( $this->itens as $item ) 
            $result[] = $item->toArray();

        return $result;
    }
}