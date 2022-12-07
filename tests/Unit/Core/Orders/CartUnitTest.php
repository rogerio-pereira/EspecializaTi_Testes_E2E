<?php

namespace Tests\Unit\Core\Orders;

use PHPUnit\Framework\TestCase;
use Core\Orders\Cart;
use Core\Orders\Product;

class CartUnitTest extends TestCase
{
    public function testCart()
    {
        $cart = new Cart();
        $cart->add(product: new Product(
            id: '1',
            name: 'Product 1',
            price: 10,
            quantity: 1,
        ));
        $cart->add(product: new Product(
            id: '2',
            name: 'Product 2',
            price: 5,
            quantity: 1,
        ));

        $this->assertCount(2, $cart->getItems()); 
        $this->assertEquals(15, $cart->getTotal()); 
    }

    public function testCartTotal()
    {
        $product1 = new Product(
            id: '1',
            name: 'Product 1',
            price: 10,
            quantity: 1,
        );
        $product2 = new Product(
            id: '2',
            name: 'Product 2',
            price: 5,
            quantity: 1,
        );

        $cart = new Cart();
        $cart->add($product1);
        $cart->add($product1);
        $cart->add($product2);

        $this->assertCount(2, $cart->getItems()); 
        $this->assertEquals(25, $cart->getTotal()); 
    }

    public function testCartEmpty()
    {
        $cart = new Cart();

        $this->assertCount(0, $cart->getItems()); 
        $this->assertEquals(0, $cart->getTotal()); 
    }
}
