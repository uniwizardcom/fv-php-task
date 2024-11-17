<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\DTO\UserDTO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Core\User\Application\Query\GetUsers\GetUsersQuery;

#[AsCommand(
    name: 'app:user:get-emails-of-unactivated',
    description: 'Pobieranie emaili nieaktywnych użytkowników'
)]
class GetEmailsOfUnactivatedUsers extends Command
{
    public function __construct(
        private readonly QueryBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->bus->dispatch(new GetUsersQuery(false));

        /** @var UserDTO $user */
        foreach ($users as $user) {
            $output->writeln($user->email);
        }

        return Command::SUCCESS;
    }
}
