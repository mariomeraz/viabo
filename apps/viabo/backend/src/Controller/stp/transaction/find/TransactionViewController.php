<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\stp\transaction\find;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Viabo\backoffice\projection\application\find_company_by_bank_account\CompanyQueryByBankAccount;
use Viabo\shared\domain\pdf\PdfRepository;
use Viabo\shared\domain\service\find_busines_template_file\BusinessTemplateFileFinder;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\bank\application\find\BankQuery;
use Viabo\stp\externalAccount\application\find\ExternalAccountQuery;
use Viabo\stp\stpAccount\application\find_stp_account_by_number\StpAccountQueryByNumber;
use Viabo\stp\transaction\application\find\TransactionQuery;

final readonly class TransactionViewController extends ApiController
{

    public function __invoke(
        string                     $transactionId,
        Request                    $request,
        Environment                $twig,
        BusinessTemplateFileFinder $templateFileFinder,
        PdfRepository              $pdfRepository
    ): Response
    {
        try {
            $transaction = $this->search($transactionId);
            $templateFile = $templateFileFinder->__invoke($transaction['businessId']);
            $data = [
                'transactionType' => 'Operación SPEI Deposito',
                'statusName' => $transaction['statusName'],
                'sourceAccount' => $transaction['sourceAccount'],
                'sourceName' => $transaction['sourceName'],
                'sourceRfc' => $transaction['sourceRfc'],
                'destinationAccount' => $transaction['destinationAccount'],
                'destinationName' => $transaction['destinationName'],
                'destinationRfc' => $transaction['destinationRfc'],
                'destinationBankName' => $transaction['bankName'],
                'amount' => $transaction['amountMoneyFormat'],
                'concept' => $transaction['concept'],
                'reference' => $transaction['trackingKey'],
                'urlCEP' => $transaction['urlCEP'],
                'date' => $transaction['createDate']
            ];
            $html = $twig->render("stp/$templateFile/notification/emails/spei.external.transaction.html.twig", $data);
            $pdf = $pdfRepository->output($html, [
                'margin-top' => 0,
                'margin-bottom' => 0,
                'page-width' => '180mm',
                'page-height' => '310mm',
            ]);
            return new Response($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="file.pdf"',
            ]);
        } catch (\DomainException $exception) {
            $html = $twig->render('stp/shared/notification/emails/transaction.spei.not.exist.html.twig');
            return new Response($html);
        }
    }

    private function search(string $transactionId): array
    {
        $transaction = $this->ask(new TransactionQuery($transactionId));
        $transaction = $transaction->data;
        $sourceAccount = $this->searchAccount($transaction['sourceAccount']);
        $destinationAccount = $this->searchAccount($transaction['destinationAccount']);
        $transaction['sourceRfc'] = $sourceAccount['rfc'];
        $transaction['destinationRfc'] = $destinationAccount['rfc'];
        $transaction['bankName'] = $destinationAccount['bankName'];
        return $transaction;
    }

    public function searchAccount(string $accountNumber): array
    {
        try {
            $account = $this->ask(new StpAccountQueryByNumber($accountNumber));
            if (empty($account->data)) {
                $account = $this->ask(new CompanyQueryByBankAccount($accountNumber));
            }
            return ['rfc' => $account->data['rfc'] ?? 'N/A', 'bankName' => 'STP'];
        } catch (\DomainException) {
        }

        try {
            $account = $this->ask(new ExternalAccountQuery($accountNumber));
            $bank = $this->ask(new BankQuery($account->data['bankId']));
            return ['rfc' => $account->data['rfc'], 'bankName' => $bank->data['shortName']];
        } catch (\DomainException) {
            return ['rfc' => $account->data['rfc'] ?? 'N/A', 'bankName' => 'N/A'];
        }
    }
}