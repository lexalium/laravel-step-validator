<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\EventListener;

use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface;
use Lexal\LaravelStepValidator\Validator\Exception\ValidatorException;
use Lexal\LaravelStepValidator\Validator\ValidatorInterface;
use Lexal\SteppedForm\EventDispatcher\Event\BeforeHandleStep;

use function is_array;

class BeforeHandleStepListener
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function handle(BeforeHandleStep $event): void
    {
        $step = $event->getStep()->getStep();

        if ($step instanceof ValidatableStepInterface && is_array($event->getData())) {
            $this->validator->validate($event->getData(), $step->getRulesDefinition($event->getEntity()));
        }
    }
}
