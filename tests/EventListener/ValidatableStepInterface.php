<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Tests\EventListener;

use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface as BaseValidatableStepInterface;
use Lexal\SteppedForm\Steps\StepInterface;

interface ValidatableStepInterface extends StepInterface, BaseValidatableStepInterface
{
}
