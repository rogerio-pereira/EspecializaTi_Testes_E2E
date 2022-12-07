<?php

namespace Tests\Unit\Core\Orders;

use PHPUnit\Framework\TestCase;
use Core\Orders\Customer;

class CustomerTest extends TestCase
{
    public function testAttributes()
    {
        $customer = new Customer(name: 'Rogerio Pereira');
        $this->assertEquals('Rogerio Pereira', $customer->getName());

        
        $customer->changeName(
            name: 'Rogerio Eduardo Pereira' 
        );
        $this->assertEquals('Rogerio Eduardo Pereira', $customer->getName());
    }
}
