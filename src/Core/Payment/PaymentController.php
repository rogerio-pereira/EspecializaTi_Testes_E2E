<?php

namespace Core\Payment;

class PaymentController
{
    private $gateway;

    public function __construct(PaymentInterface $gateway)
    {
        $this->gateway = $gateway;
    }
}