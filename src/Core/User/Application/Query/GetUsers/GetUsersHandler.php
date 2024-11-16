<?php

namespace App\Core\User\Application\Query\GetUsers;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUsersQuery $query): array
    {
        $users = $this->userRepository->getAll(
            $query->isActive
        );

        return array_map(function (User $user) {
            return new UserDTO(
                $user->getId(),
                $user->getEmail(),
                $user->getIsActive()
            );
        }, $users);
    }
}
