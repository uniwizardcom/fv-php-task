<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Common\CurrencyTranslator\AmountTranslator;
use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceForActiveUserHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateInvoiceForActiveUserCommand $command): void
    {
        $this->invoiceRepository->save(new Invoice(
            $this->userRepository->getActiveUser($command->email),
            $command->amount
        ));

        $this->invoiceRepository->flush();
    }
}
