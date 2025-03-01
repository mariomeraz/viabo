<?php declare(strict_types=1);

namespace Viabo\Tests\shared\infrastructure\mink;

use Behat\Mink\Driver\DriverInterface;
use Behat\Mink\Session;
use PHPUnit\Logging\Exception;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Crawler;

final class MinkHelper
{

    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function sendRequest(string $method , string $url , array $optionalParams = [], array $headers = []): Crawler
    {
        $authorization = $headers['authorization'] ?? '';
        $username = $headers['username'] ?? '';
        $defaultOptionalParams = [
            'parameters' => [] ,
            'files' => [] ,
            'server' => [
                'HTTP_ACCEPT' => 'application/json' ,
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer '.$authorization,
                'HTTP_Host' => 'system.viabo.com:80',
                'HTTP_Username' => $username
            ] ,
            'content' => null ,
            'changeHistory' => true ,
        ];

        $optionalParams = array_merge($defaultOptionalParams , $optionalParams);

        return $this->getClient()->request(
            $method ,
            $url ,
            $optionalParams['parameters'] ,
            $optionalParams['files'] ,
            $optionalParams['server'] ,
            $optionalParams['content'] ,
            $optionalParams['changeHistory']
        );
    }

    public function getResponse(): string
    {
        return $this->getSession()->getPage()->getContent();
    }

    public function getResponseHeaders(): array
    {
        return $this->normalizeHeaders(array_change_key_case($this->getSession()->getResponseHeaders() , CASE_LOWER));
    }

    public function setRequestHeader(string $header , string $value): void
    {
        $this->getSession()->getDriver()->setRequestHeader($header , $value);
    }

    public function resetServerParameters(): void
    {
        $this->getClient()->setServerParameters([]);
    }

    public function getRequest(): object
    {
        return $this->getClient()->getRequest();
    }

    private function getSession(): Session
    {
        return $this->session;
    }

    private function getDriver(): DriverInterface
    {
        return $this->getSession()->getDriver();
    }

    private function getClient(): AbstractBrowser
    {
        return $this->getDriver()->getClient();
    }

    private function normalizeHeaders(array $headers): array
    {
        return array_map('implode' , array_filter($headers));
    }

    private function resetRequestStuff(): void
    {
        $this->getSession()->reset();
        $this->resetServerParameters();
    }

}