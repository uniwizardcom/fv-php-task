<?php

namespace App\Core\Invoice\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Common\CurrencyTranslator\AmountException;
use App\Common\CurrencyTranslator\AmountTranslator;
use App\Core\Invoice\Application\DTO\InvoiceDTO;
use App\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater\GetInvoicesByStatusAndAmountGreaterQuery;
use App\Core\Invoice\Domain\Status\InvoiceStatus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:invoice:get-by-status-and-amount',
    description: 'Pobieranie identyfikatorów faktur dla wybranego statusu i kwot większych od'
)]
class GetInvoices extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    /**
     * @throws AmountException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $invoices = $this->bus->dispatch(new GetInvoicesByStatusAndAmountGreaterQuery(
            (int)$input->getArgument('amount'),
            $this->parseArgStatus($input->getArgument('status'))
        ));

        /** @var InvoiceDTO $invoice */
        foreach ($invoices as $invoice) {
            $output->writeln($invoice->id);
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('status', InputArgument::REQUIRED);
        $this->addArgument('amount', InputArgument::REQUIRED);
    }

    /**
     * @param string $status
     *
     * @return InvoiceStatus
     * @throws \Exception
     */
    private function parseArgStatus(string $status): InvoiceStatus
    {
        $result = InvoiceStatus::tryFrom($status);
        if(!$result) {
            throw new \Exception('Wartość ['. $status .'] nie jest żadnym z dostępnych statusów');
        }

        return $result;
    }
}
