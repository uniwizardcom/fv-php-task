<?php

namespace App\Core\User\Application\Query\GetUsers;

class GetUsersQuery
{
    public function __construct(
        public readonly ?bool $isActive
    ) {}
}
