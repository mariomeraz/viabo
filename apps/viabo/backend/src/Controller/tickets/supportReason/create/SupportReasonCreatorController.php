<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\supportReason\create;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\supportReason\application\create\CreateSupportReasonCommand;

final readonly class SupportReasonCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new CreateSupportReasonCommand(
                $tokenData['id'] ,
                $data['reason'] ,
                $data['description'] ,
                $data['applicantProfileId'] ,
                $data['assignedProfileId'] ,
                $data['color']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}