<?php

namespace Core\Orders;

class Cart
{
    /**
     * @var Product[]
     */
    private $items = [];

    public function add(Product $product)
    {
        $productId = $product->getId();

        //If items doesn't exist, add it with quantity 1
        if(!array_key_exists($productId, $this->items)) {
            $this->items[$productId] = [
                                            'quantity' => 1, 
                                            'product' => $product
                                        ];
        }
        //Add 1 to quantity 
        else {
            $this->items[$productId]['quantity']++;
        }
    }

    public function getItems() : array
    {
        return $this->items;
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            $total += $product->getPrice() * $quantity;
        }

        return $total;
    }
}
