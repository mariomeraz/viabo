<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Viabo\backoffice\projection\application\find_company_by_bank_account\CompanyQueryByBankAccount;
use Viabo\shared\domain\pdf\PdfRepository;
use Viabo\shared\domain\service\find_busines_template_file\BusinessTemplateFileFinder;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\stpAccount\application\find_stp_account_by_number\StpAccountQueryByNumber;
use Viabo\stp\transaction\application\find_statement_account_by_company_for_pdf\StatementAccountQueryByCompanyForPdf;
use Viabo\stp\transaction\application\find_statement_account_by_stp_account_for_pdf\StatementAccountQueryByStpAccountForPdf;


final readonly class StatementAccountPdfFinderController extends ApiController
{

    public function __invoke(
        Request                    $request,
        Environment                $twig,
        BusinessTemplateFileFinder $templateFileFinder,
        PdfRepository              $pdfRepository
    ): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $account = $request->query->getInt('account');
            $month = $request->query->getInt('month');
            $year = $request->query->getInt('year');
            $templateFile = $templateFileFinder->__invoke($tokenData['businessId']);
            $pdfData = $this->searchTransactions($account, $month, $year);

            $body = $twig->render("stp/$templateFile/pdf/statementAccount/body.statement.account.html.twig", $pdfData);
            $header = $twig->render("stp/$templateFile/pdf/statementAccount/header.statement.account.html.twig");
            $footer = $twig->render("stp/$templateFile/pdf/statementAccount/footer.statement.account.html.twig");
            $options = [
                'header-html' => $header,
                'footer-html' => $footer,
                'margin-top' => '35mm',
                'margin-bottom' => '10mm'
            ];

            $pdf = $pdfRepository->output($body, $options);
            return new Response($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="file.pdf"',
            ]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function searchTransactions(int $account, int $month, int $year): array
    {
        $stpAccount = $this->ask(new StpAccountQueryByNumber(strval($account)));

        if (empty($stpAccount->data)) {
            return $this->searchTransactionsByCompany($account, $month, $year);
        }

        return $this->searchTransactionsByStpAccount($stpAccount->data[0], $month, $year);
    }

    private function searchTransactionsByCompany(int $account, int $month, int $year): array
    {
        $company = $this->ask(new CompanyQueryByBankAccount(strval($account)));
        $statementAccount = $this->ask(new StatementAccountQueryByCompanyForPdf($account, $month, $year));
        return array_merge($statementAccount->data, ['company' => $company->data]);
    }

    private function searchTransactionsByStpAccount(array $stpAccount, int $month, int $year): array
    {
        $transactions = $this->ask(new StatementAccountQueryByStpAccountForPdf($stpAccount, $month, $year));
        return $transactions->data;
    }

}