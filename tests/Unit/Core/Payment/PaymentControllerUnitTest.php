<?php

namespace Tests\Unit\Core\Payment;

use Core\Payment\PaymentController;
use Core\Payment\PaymentInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class PaymentControllerUnitTest extends TestCase
{
    protected function tearDown() : void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testPayment()
    {
        $mockPayment = Mockery::mock(stdClass::class, PaymentInterface::class);
        $mockPayment->shouldReceive('makePayment')
            ->once() //times(1)
            ->andReturn(true);

        $payment = new PaymentController($mockPayment);
        $response = $payment->execute();

        $this->assertTrue($response);
    }
}