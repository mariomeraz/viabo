<?php declare(strict_types=1);

namespace Viabo\Tests\security\src\healthCheckTest\application;

use PHPUnit\Framework\TestCase;

final class HealthCheckCommandHandlerTest extends TestCase
{
    /** @test */
    public function healthCheck(): void
    {
        $value = 'hello';
        $this->assertSame('hello',$value);
    }

}