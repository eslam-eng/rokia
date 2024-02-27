<?php

namespace App\Interfaces;

interface TherapistInvoiceInterface
{
    public function getPrice();
    public function getDetails();
    public function getType();

}
