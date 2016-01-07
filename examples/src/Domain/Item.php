<?php
namespace App\Domain;

interface Item 
{
    public function getName();
    public function toArray();
}
