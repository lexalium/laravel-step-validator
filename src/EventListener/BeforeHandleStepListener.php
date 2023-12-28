<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\EventListener;

use Lexal\LaravelStepValidator\Exception\ValidatorException;
use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface;
use Lexal\LaravelStepValidator\ValidatorInterface;
use Lexal\SteppedForm\EventDispatcher\Event\BeforeHandleStep;

use function is_array;

final class BeforeHandleStepListener
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function handle(BeforeHandleStep $event): void
    {
        $step = $event->step->step;

        if ($step instanceof ValidatableStepInterface && is_array($event->getData())) {
            $this->validator->validate($event->getData(), $step->getRulesDefinition($event->entity));
        }
    }
}
