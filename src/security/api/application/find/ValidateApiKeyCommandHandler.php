<?php declare(strict_types=1);


namespace Viabo\security\api\application\find;


use Viabo\security\api\domain\ApiKey;
use Viabo\security\api\domain\ApiName;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ValidateApiKeyCommandHandler implements CommandHandler
{
    public function __construct(private ApiKeyFinder $finder)
    {
    }

    public function __invoke(ValidateApiKeyCommand $command): void
    {
        $name = ApiName::create($command->apiName);
        $key = ApiKey::create($command->apiKey);
        $this->finder->__invoke($name , $key);
    }
}