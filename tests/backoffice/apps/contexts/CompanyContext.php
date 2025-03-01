<?php

namespace Viabo\Tests\backoffice\apps\contexts;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use RuntimeException;
use Viabo\shared\infrastructure\doctrine\DatabaseConnections;
use Viabo\Tests\shared\infrastructure\behat\VariablesContext;
use Viabo\Tests\shared\infrastructure\mink\MinkHelper;
use Viabo\Tests\shared\infrastructure\mink\MinkSessionRequestHelper;

final class CompanyContext extends RawMinkContext
{
    private readonly MinkHelper $sessionHelper;
    private readonly MinkSessionRequestHelper $request;

    public function __construct(
        private readonly Session          $minkSession,
        private readonly VariablesContext $variables,
        private DatabaseConnections       $connections
    )
    {
        $this->sessionHelper = new MinkHelper($minkSession);
        $this->request = new MinkSessionRequestHelper(new MinkHelper($minkSession));
        $_SERVER['SERVER_NAME'] = $_ENV['BEHAT_SERVER_NAME'];
        $_SERVER['SERVER_PORT'] = $_ENV['BEHAT_SERVER_PORT'];
    }

    /**
     * @When /^que el usuario "([^"]*)" no existe$/
     */
    public function queElUsuarioNoExiste($arg1)
    {
        $this->connections->clearRecords([
            ['table' => 't_users', 'field' => 'Email', 'operator' => '=', 'value' => $arg1],
            ['table' => 't_backoffice_companies_and_users', 'field' => 'Email', 'operator' => '=', 'value' => 'fpalma@siccob.com.mx']
        ]);
    }

    /**
     * @When /^verifico al usuario "([^"]*)"$/
     */
    public function verificoAlUsuario($email)
    {
        $body = ['content' => ''];
        $headers = array_merge(['authorization' => $this->variables->getToken()], ['username' => $email]);
        $this->request->request('GET', $this->locatePath('/api/legal-representative/verificate'), $body, $headers);
        $response = $this->sessionHelper->getResponse();

        if ($this->minkSession->getStatusCode() !== 200) {
            throw new RuntimeException(sprintf($response));
        }

        $data = json_decode($response, true);
        $this->variables->setToken($data['token']);
    }
}
