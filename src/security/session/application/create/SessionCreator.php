<?php declare(strict_types=1);


namespace Viabo\security\session\application\create;


use Viabo\security\session\domain\services\SessionUpdater;
use Viabo\security\session\domain\Session;
use Viabo\security\session\domain\SessionRepository;

final readonly class SessionCreator
{
    public function __construct(
        private SessionRepository $repository,
        private SessionUpdater    $updater
    )
    {
    }

    public function __invoke(string $userId, string $loginDate): void
    {
        $this->closeOpenSession($userId);
        $session = Session::create($userId, $loginDate);
        $this->repository->save($session);
    }

    private function closeOpenSession(string $userId): void
    {
        $this->updater->__invoke($userId);
    }
}