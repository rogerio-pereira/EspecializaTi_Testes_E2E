<?php

namespace Core\Payment;

class PaymentController
{
    private $gateway;

    public function __construct(PaymentInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function execute()
    {
        return $this->gateway->makePayment([]);
    }
}