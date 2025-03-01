<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\authenticatorFactor\application\find\AuthenticatorFactorsQuery;
use Viabo\security\authenticatorFactor\application\validation\ValidateGoogleAuthenticatorCommand;
use Viabo\security\user\application\find\UserQueryByUsername;
use Viabo\security\user\application\update_data\UpdateUserDataCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class UserUpdaterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $userId = $tokenData['id'];

            $this->dispatch(new ValidateGoogleAuthenticatorCommand(
                $userId,
                $tokenData['name'],
                $data['googleAuthenticatorCode']
            ));

            $this->dispatch(new UpdateUserDataCommand(
                $userId,
                $data['name'],
                $data['lastName'],
                $data['email'],
                $data['phone']
            ));

            $user = $this->ask(new UserQueryByUsername($data['email']));
            $user = $user->data;
            $user['authenticatorFactors'] = $this->validateAuthenticatorFactor($user);
            $token = $this->encode($user);

            return new JsonResponse(['token' => $token]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
    public function validateAuthenticatorFactor($user): bool
    {
        $authenticatorFactors = $this->ask(new AuthenticatorFactorsQuery($user['id']));
        return !empty($authenticatorFactors->data);
    }
}
