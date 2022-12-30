<?php

namespace Signature\Logging;

use PHPUnit\Framework\TestCase;
use Signature\Logging\Logger\ErrorlogLogger;
use Signature\Logging\Logger\FilewriterLogger;

class LoggingServiceTest extends TestCase
{
    /** @var LoggingService */
    private $service;

    protected function setUp(): void
    {
        $this->service = new LoggingService();
    }

    public function testChainability()
    {
        $this->assertInstanceOf(
            LoggingService::class,
            $this->service->registerLogger(new ErrorlogLogger())
        );

        $this->assertInstanceOf(
            LoggingService::class,
            $this->service->log('Message #1')
        );
    }

    public function testRegisterAndGettingLoggers()
    {
        $this->service->registerLogger(new ErrorlogLogger());

        $this->assertCount(1, $this->service->getRegisteredLoggers());
    }

    public function testGettingARegisteredLogger()
    {
        $this->service->registerLogger(new ErrorlogLogger());

        $this->assertInstanceOf(
            ErrorlogLogger::class,
            $this->service->getLogger(ErrorlogLogger::class)
        );
    }

    public function testGettingANotRegisteredLoggerThrowsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->service->getLogger(FilewriterLogger::class);
    }
}
