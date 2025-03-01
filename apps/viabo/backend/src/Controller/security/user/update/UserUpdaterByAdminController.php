<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\update_data\UpdateUserDataCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class UserUpdaterByAdminController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();

            $this->dispatch(new UpdateUserDataCommand(
                $data['userId'],
                $data['name'],
                $data['lastName'],
                $data['email'],
                $data['phone']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
