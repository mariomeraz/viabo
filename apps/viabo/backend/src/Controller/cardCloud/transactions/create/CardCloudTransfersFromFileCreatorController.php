<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\transactions\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\subAccount\application\find_sub_account_by_company\SubAccountCardCloudServiceByCompanyQuery;
use Viabo\cardCloud\transactions\application\create_card_transfer_from_file\CreateCardCloudCardTransferFromFileCommand;
use Viabo\shared\domain\excel\ExcelRepository;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudTransfersFromFileCreatorController extends ApiController
{

    public function __invoke(Request $request, ExcelRepository $excelRepository): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $subAccountId = $request->request->get('subAccount');
            $file = $request->files->get('file');
            $fileData = $excelRepository->data($file);
            $this->dispatch(new CreateCardCloudCardTransferFromFileCommand(
                $tokenData['businessId'], $subAccountId, $fileData
            ));
            $subAccount = $this->ask(new SubAccountCardCloudServiceByCompanyQuery(
                $tokenData['businessId'],
                $subAccountId
            ));

            return new JsonResponse($subAccount->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
