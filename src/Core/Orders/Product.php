<?php

namespace Core\Orders;

class Product
{
    public function __construct(
        protected string $name,
        protected float $price,
        protected int $quantity,
    ) { } 
    
    public function changeName(string $name)
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }
    
    public function changePrice(float $price)
    {
        $this->price = $price;
    }

    public function getPrice() : float
    {
        return $this->price;
    }
    
    public function changeQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function getTotal() : float
    {
        return $this->price * $this->quantity;
    }

    public function getTotalWithDiscount() : float
    {
        return $this->price * $this->quantity * (1 - $this->getDiscount());
    }

    public function getDiscount() : float
    {
        if($this->quantity < 5)
            return 0.1;
        elseif($this->quantity == 5)
            return 0.15;
        elseif($this->quantity > 5)
            return 0.2;
    }
}
