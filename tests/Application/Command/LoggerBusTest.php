<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Psr\Log\LoggerInterface;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

class LoggerBusTest extends UnitTestCase
{
    public function testExecute(): void
    {
        $innerBus = $this->createMock(Command\Bus::class);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::never())->method('error');

        $loggerBus = new Command\LoggerBus($logger, $innerBus);

        $command = $this->createMock(Command::class);

        $loggerBus->execute($command);
    }

    public function testExceptionIsLogged(): void
    {
        $exception = new Command\RuntimeException('catch me', 330);

        $innerBus = $this->createMock(Command\Bus::class);
        $innerBus->method('execute')->willThrowException($exception);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())->method('error')->with(
            'catch me',
            self::callback(static function (array $context) use ($exception) {
                return $context['code'] === $exception->getCode()
                    && $context['exception'] === $exception
                    && $context['unique_command_fqcn']['fqcnHandler'] === 'unique_fqcn_handler';
            }),
        );

        $loggerBus = new Command\LoggerBus($logger, $innerBus);

        /**
         * Mock MockObject's internal method with name "method" to avoid recursion
         *
         * @see LoggerBus::dumpCommandMethods
         * @see \PHPUnit\Framework\MockObject\Generator::generateMock
         * @see vendor/phpunit/phpunit/src/Framework/MockObject/Generator/mocked_class_method.tpl.dist
         *
         * @psalm-suppress DeprecatedMethod
         * @see https://github.com/sebastianbergmann/phpunit/issues/3911
         */
        $command = $this
            ->getMockBuilder(Command::class)
            ->setMockClassName('unique_command_fqcn')
            ->setMethods(['fqcnHandler', 'method'])
            ->getMock();

        $command->expects(self::any())
            ->method('fqcnHandler')
            ->willReturn('unique_fqcn_handler');

        $this->expectException(Command\RuntimeException::class);
        $this->expectExceptionCode($exception->getCode());

        /**
         * @psalm-suppress InvalidArgument
         */
        $loggerBus->execute($command);
    }
}
