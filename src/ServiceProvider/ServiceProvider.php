<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\ServiceProvider;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Lexal\LaravelStepValidator\EventListener\BeforeHandleStepListener;
use Lexal\LaravelStepValidator\Validator;
use Lexal\LaravelStepValidator\ValidatorInterface;
use Lexal\SteppedForm\EventDispatcher\Event\BeforeHandleStep;
use LogicException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function sprintf;

final class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function boot(): void
    {
        if ($this->app->bound(Dispatcher::class)) {
            /** @var Dispatcher $dispatcher */
            $dispatcher = $this->app->get(Dispatcher::class);

            $dispatcher->listen(BeforeHandleStep::class, [BeforeHandleStepListener::class, 'handle']);
        }
    }

    public function register(): void
    {
        if (!$this->app->bound(ValidationFactory::class)) {
            throw new LogicException(
                sprintf(
                    'Unable to register %s. Provide your own implementation of %s or install the %s package.',
                    ValidatorInterface::class,
                    ValidationFactory::class,
                    'illuminate/validation',
                ),
            );
        }

        $this->app->singleton(ValidatorInterface::class, Validator::class);
    }
}
