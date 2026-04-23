<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Tests\ServiceProvider;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Lexal\LaravelStepValidator\EventListener\BeforeHandleStepListener;
use Lexal\LaravelStepValidator\ServiceProvider\ServiceProvider;
use Lexal\LaravelStepValidator\Tests\TestApplication;
use Lexal\LaravelStepValidator\Tests\TestDispatcher;
use Lexal\LaravelStepValidator\ValidatorInterface;
use Lexal\SteppedForm\EventDispatcher\Event\BeforeHandleStep;
use LogicException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class ServiceProviderTest extends TestCase
{
    public function testBoot(): void
    {
        $app = new TestApplication();

        $app->singleton(Dispatcher::class, static fn(): Dispatcher => new TestDispatcher());

        $serviceProvider = new ServiceProvider($app);

        $serviceProvider->boot();

        /** @var TestDispatcher $dispatcher */
        $dispatcher = $app->get(Dispatcher::class);

        self::assertEquals(
            [BeforeHandleStepListener::class, 'handle'],
            $dispatcher->getListener(BeforeHandleStep::class),
        );
    }

    public function testBootWithoutDispatcher(): void
    {
        $app = new TestApplication();

        $serviceProvider = new ServiceProvider($app);

        $serviceProvider->boot();

        $app->singleton(Dispatcher::class, static fn(): Dispatcher => new TestDispatcher());
        /** @var TestDispatcher $dispatcher */
        $dispatcher = $app->get(Dispatcher::class);

        self::assertNull($dispatcher->getListener(BeforeHandleStep::class));
    }

    public function testRegister(): void
    {
        $app = new TestApplication();

        $app->singleton(
            ValidationFactory::class,
            fn (): ValidationFactory => $this->createMock(ValidationFactory::class),
        );

        $serviceProvider = new ServiceProvider($app);

        $serviceProvider->register();

        self::assertTrue($app->bound(ValidatorInterface::class));

        $app->get(ValidatorInterface::class);
    }

    public function testRegisterThrowsWhenValidationFactoryNotRegistered(): void
    {
        $this->expectExceptionObject(
            new LogicException(
                sprintf(
                    'Unable to register %s. Provide your own implementation of %s or install the %s package.',
                    ValidatorInterface::class,
                    ValidationFactory::class,
                    'illuminate/validation',
                )
            ),
        );

        $serviceProvider = new ServiceProvider(new TestApplication());

        $serviceProvider->register();
    }
}
