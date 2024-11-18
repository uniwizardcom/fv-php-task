<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\User;
use App\Core\User\Domain\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email, bool $onlyActiveUser = false): User;

    public function save(User $invoice): void;

    public function flush(): void;
}
