<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\commerceUser\application\create\CreateCommerceUserCommand;
use Viabo\management\card\application\update\UpdateCardOwnerCommand;
use Viabo\security\user\application\create\CreateUserCommand;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceCardUserUpdaterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $userId = $this->generateUuid();
            $lastname = '';
            $this->dispatch(new CreateUserCommand(
                $userId,
                $data['name'],
                $lastname,
                $data['email'],
                $data['phone']
            ));
            $userData = $this->ask(new FindUserQuery('', $data['email']));
            $userId = $userData->data['id'];
            $this->dispatch(new CreateCommerceUserCommand($userId, $data['cards']));
            $this->dispatch(new UpdateCardOwnerCommand($data['cards'], $userId));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}