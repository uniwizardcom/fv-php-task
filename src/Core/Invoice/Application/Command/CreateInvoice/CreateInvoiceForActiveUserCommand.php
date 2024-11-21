<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

class CreateInvoiceForActiveUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly int $amount
    ) {}
}
