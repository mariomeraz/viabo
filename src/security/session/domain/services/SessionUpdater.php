<?php declare(strict_types=1);


namespace Viabo\security\session\domain\services;


use Viabo\security\session\domain\SessionRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class SessionUpdater
{
    public function __construct(private SessionRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $userId): void
    {
        $session = $this->repository->search($userId);

        if (!empty($session)) {
            $session->setLogout();
            $this->repository->update($session);
            $this->bus->publish(...$session->pullDomainEvents());
        }
    }
}