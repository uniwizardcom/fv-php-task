<?php

namespace App\Core\User\Infrastructure\Persistance;

use App\Core\User\Domain\Exception\UserNotActiveException;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    /**
     * @param string $email
     *
     * @return User
     * @throws NonUniqueResultException
     */
    public function getByEmail(string $email): User
    {
        $userBuilder = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :user_email')->setParameter(':user_email', $email)
            ->setMaxResults(1);

        $user = $userBuilder->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            throw new UserNotFoundException('Użytkownik nie istnieje');
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getActiveUser(string $email): User
    {
        $user = $this->getByEmail($email);

        if(!$user->getIsActive()) {
            throw new UserNotActiveException('Użytkownik nie jest aktywny');
        }

        return $user;
    }

    public function getAll(?bool $isActive): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        if($isActive !== null) {
            $queryBuilder->andWhere('u.is_active = :is_active')->setParameter(':is_active', $isActive);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);

        $events = $user->pullEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
