<?php declare(strict_types=1);


namespace Viabo\security\code\application\create;


use Viabo\security\code\domain\Code;
use Viabo\security\code\domain\CodeRepository;
use Viabo\security\code\domain\services\DeleteCodeExist;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CodeCreator
{
    public function __construct(
        private CodeRepository  $repository,
        private DeleteCodeExist $deleteCodeExist,
        private EventBus        $bus
    )
    {
    }

    public function __invoke(array $user): void
    {
        $this->deleteCodeExist->__invoke($user['id']);
        $code = Code::create($user);
        $this->repository->save($code);

        $this->bus->publish(...$code->pullDomainEvents());
    }
}