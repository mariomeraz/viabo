<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\supportReason\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\profile\application\find\ProfileQuery;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\supportReason\application\find\SupportReasonsQuery;

final readonly class SupportReasonsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $supportReasons = $this->ask(new SupportReasonsQuery());
            $supportReasons = $this->mergeProfileName($supportReasons->data);

            return new JsonResponse($supportReasons);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    private function mergeProfileName(array $supportReasons): array
    {
        return array_map(function (array $supportReason) {
            $applicantProfile = $this->ask(new ProfileQuery($supportReason['applicantProfileId']));
            $assignedProfileId = $this->ask(new ProfileQuery($supportReason['assignedProfileId']));
            $supportReason['applicantProfileName'] = $applicantProfile->data['name'];
            $supportReason['assignedProfileName'] = $assignedProfileId->data['name'];
            return $supportReason;
        } , $supportReasons);

    }
}