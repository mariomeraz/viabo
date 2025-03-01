<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\receipt;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\cardMovement\application\create\CreateCardsMovementsCommandByReceipt;
use Viabo\management\receipt\application\create\CreateReceiptCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class ReceiptCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $movements = $request->request->get('movements');
            $note = $request->request->get('note');
            $isInvoice = $request->request->getBoolean('isInvoice');
            $files = $request->files->all();
            $files = empty($files) ? ['files' =>[]]: $files;
            $receiptId = $this->generateUuid();

            $this->dispatch(new CreateReceiptCommand(
                $tokenData['id'] ,
                $receiptId ,
                $movements ,
                $note ,
                $files['files'] ,
                $isInvoice
            ));
            $this->dispatch(new CreateCardsMovementsCommandByReceipt($receiptId , $movements));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
