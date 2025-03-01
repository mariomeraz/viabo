<?php

namespace Viabo\Tests\stp\apps\context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use Viabo\shared\infrastructure\doctrine\DatabaseConnections;
use Viabo\Tests\shared\infrastructure\mink\MinkHelper;
use Viabo\Tests\shared\infrastructure\mink\MinkSessionRequestHelper;

final class StpContext extends RawMinkContext
{
    private readonly MinkHelper $sessionHelper;
    private readonly MinkSessionRequestHelper $request;

    public function __construct(
        private readonly Session    $minkSession,
        private DatabaseConnections $connections
    )
    {
        $this->sessionHelper = new MinkHelper($minkSession);
        $this->request = new MinkSessionRequestHelper(new MinkHelper($minkSession));
        $_SERVER['SERVER_NAME'] = $_ENV['BEHAT_SERVER_NAME'];
        $_SERVER['SERVER_PORT'] = $_ENV['BEHAT_SERVER_PORT'];
    }

    /**
     * @When /^se limpia el registro del usuario "([^"]*)" de la empresa "([^"]*)"$/
     */
    public function seLimpiaElRegistroDelUsuarioDeLaEmpresa($email, $companyId)
    {
        $this->connections->clearRecords([
            ['table' => 't_users', 'field' => 'Email', 'operator' => '=', 'value' => $email],
            ['table' => 't_stp_card_cloud_users', 'field' => 'Email', 'operator' => '=', 'value' => $email],
            ['table' => 't_backoffice_companies_and_users', 'field' => 'Email', 'operator' => '=', 'value' => 'fpalma@siccob.com.mx']
        ]);
        $this->connections->updateRecords([
            ['table' => 't_backoffice_companies_projection', 'field' => 'Users', 'operator' => '=', 'value' => '[]']
        ],['field' => 'Id', 'operator' => '=', 'value' => $companyId]);
    }

    /**
     * @When /^que elimina el registro "([^"]*)" para quitar la asignacion$/
     */
    public function queEliminaElRegistroParaQuitarLaAsignacion($cardNumber)
    {
        $this->connections->clearRecords([
            ['table' => 't_stp_card_cloud_users', 'field' => 'CardCloudId', 'operator' => '=', 'value' => $cardNumber],
        ]);
    }
}
