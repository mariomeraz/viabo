<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\bus\event;


use Viabo\shared\domain\bus\event\DomainEvent;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\infrastructure\bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class DomainEventMapping implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    CallableFirstParameterExtractor::forPipedCallables($subscribers)
                )
            )
        ]);
    }

    public function publish(DomainEvent ...$events)
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException $exception) {
            }
        }
    }
}