<?php

namespace Signature\Logging;

use PHPUnit\Framework\TestCase;
use Signature\Logging\Logger\ErrorlogLogger;
use Signature\Logging\Logger\LoggerInterface;

class LoggerServiceTest extends TestCase
{
    /** @var ErrorlogLogger */
    private $logger;

    protected function setUp(): void
    {
        $this->logger = new ErrorlogLogger();
    }

    public function testLoggingWithInvalidPriority()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->logger->log('Message', 0);
    }

    public function testSettingAndGettingLogFilter()
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->logger->setLogFilter(LoggerInterface::PRIORITY_ERROR));
        $this->assertEquals(LoggerInterface::PRIORITY_ERROR, $this->logger->getLogFilter());
    }

    public function testPriority2StringMethod()
    {
        $this->assertEquals('NORMAL', $this->logger->priority2String(LoggerInterface::PRIORITY_NORMAL));
        $this->assertEquals('NOTICE', $this->logger->priority2String(LoggerInterface::PRIORITY_NOTICE));
        $this->assertEquals('WARNING', $this->logger->priority2String(LoggerInterface::PRIORITY_WARNING));
        $this->assertEquals('ERROR', $this->logger->priority2String(LoggerInterface::PRIORITY_ERROR));
        $this->assertEquals('CRITICAL', $this->logger->priority2String(LoggerInterface::PRIORITY_CRITICAL));
    }
}
