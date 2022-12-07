<?php

namespace Tests\Unit\Core\Orders;

use PHPUnit\Framework\TestCase;
use Core\Orders\Product;
use Mockery;

class ProductUnitTest extends TestCase
{
    public function testAttributes()
    {
        $product = new Product(
            id: 'id',
            name: 'Product',
            price: 12.59,
            quantity: 5
        );
        
        $this->assertEquals('id', $product->getId());
        $this->assertEquals('Product', $product->getName());
        $this->assertEquals(12.59, $product->getPrice());
        $this->assertEquals(5, $product->getQuantity()); 

        $product->changeName(name: 'Product New');
        $this->assertEquals('Product New', $product->getName());

        $product->changePrice(price: 50.32);
        $this->assertEquals(50.32, $product->getPrice());

        $product->changeQuantity(quantity: 10);
        $this->assertEquals(10, $product->getQuantity());
    }

    public function testTotal()
    {
        $product = new Product(
            id: '1',
            name: 'Product',
            price: 12.59,
            quantity: 5
        );
        $this->assertEquals(62.95, $product->getTotal());
    }

    public function testDiscountLessThanFiveItemsShouldGiveTenPercent()
    {
        $product = new Product(
            id: '1',
            name: 'Product',
            price: 10,
            quantity: 4
        );
        $this->assertEquals(0.1, $product->getDiscount());
        $this->assertEquals(36, $product->getTotalWithDiscount());
    }

    public function testDiscountFiveItemsShouldGiveFifteenPercent()
    {
        $product = new Product(
            id: '1',
            name: 'Product',
            price: 10,
            quantity: 5
        );
        $this->assertEquals(0.15, $product->getDiscount());
        $this->assertEquals(42.5, $product->getTotalWithDiscount());
    }

    public function testDiscountMoreThanFiveItemsShouldGiveTwentyPercent()
    {
        $product = new Product(
            id: '1',
            name: 'Product',
            price: 10,
            quantity: 6
        );
        $this->assertEquals(0.2, $product->getDiscount());
        $this->assertEquals(48, $product->getTotalWithDiscount());
    }

    public function testExampleMockProduct()
    {
        //Just showing how to mock a class that needs parameters in constructor
        $mockProduct = Mockery::mock(Product::class, [
                                'abc123',        //ID
                                'Product',  //Name
                                10.29,      //Price
                                2,          //Total
                            ]);
        $mockProduct->shouldReceive('getId')
            ->andReturn('abc123');

        Mockery::close();

        $this->assertTrue(true);    //Only to pass the test, what's important here is how to mock the product
    }
}
