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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
        if ($this->app->bound(ValidationFactory::class)) {
            $this->app->singleton(ValidatorInterface::class, Validator::class);
        }
    }
}
