<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotActiveException;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    /**
     * @throws UserNotFoundException
     * @throws UserNotActiveException
     */
    public function getActiveUser(string $email): User;

    public function save(User $invoice): void;

    public function flush(): void;
}
