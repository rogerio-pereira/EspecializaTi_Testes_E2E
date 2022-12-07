<?php

namespace Core\Payment;

class Stripe implements PaymentInterface
{
    public function createPlan() : bool
    {
        return [];
    }

    public function findClientById(string $id) : ?object
    {
        return null;
    }

    public function makePayment(array $data) : bool 
    {
        return false;
    }
}