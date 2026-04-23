<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Tests\EventListener;

use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface as BaseValidatableStepInterface;
use Lexal\SteppedForm\Step\StepInterface;

/**
 * @template-extends StepInterface<object>
 * @template-extends BaseValidatableStepInterface<object>
 */
interface ValidatableStepInterface extends StepInterface, BaseValidatableStepInterface
{
}
