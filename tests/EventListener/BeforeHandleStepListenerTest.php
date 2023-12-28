<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Tests\EventListener;

use Lexal\LaravelStepValidator\EventListener\BeforeHandleStepListener;
use Lexal\LaravelStepValidator\Exception\ValidatorException;
use Lexal\LaravelStepValidator\RulesDefinition;
use Lexal\LaravelStepValidator\ValidatorInterface;
use Lexal\SteppedForm\EventDispatcher\Event\BeforeHandleStep;
use Lexal\SteppedForm\Step\Step;
use Lexal\SteppedForm\Step\StepInterface;
use Lexal\SteppedForm\Step\StepKey;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class BeforeHandleStepListenerTest extends TestCase
{
    private MockObject $validator;
    private BeforeHandleStepListener $listener;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->listener = new BeforeHandleStepListener($this->validator);
    }

    public function testHandle(): void
    {
        $this->validator->expects($this->once())
            ->method('validate')
            ->with(['data' => 'test'], new RulesDefinition(['data' => 'required'], ['data' => 'test message']));

        $step = $this->createStub(ValidatableStepInterface::class);

        $step->method('getRulesDefinition')
            ->willReturn(new RulesDefinition(['data' => 'required'], ['data' => 'test message']));

        $event = new BeforeHandleStep(['data' => 'test'], ['entity'], new Step(new StepKey('key'), $step));

        $this->listener->handle($event);
    }

    public function testHandleWithErrors(): void
    {
        $this->expectExceptionObject(new ValidatorException(['data' => 'required message']));

        $this->validator->expects($this->once())
            ->method('validate')
            ->with(['data' => 'test'], new RulesDefinition(['data' => 'required']))
            ->willThrowException(new ValidatorException(['data' => 'required message']));

        $step = $this->createStub(ValidatableStepInterface::class);

        $step->method('getRulesDefinition')
            ->willReturn(new RulesDefinition(['data' => 'required']));

        $event = new BeforeHandleStep(['data' => 'test'], ['entity'], new Step(new StepKey('key'), $step));

        $this->listener->handle($event);
    }

    public function testHandleDataIsNorArray(): void
    {
        $this->validator->expects($this->never())
            ->method('validate');

        $step = $this->createStub(ValidatableStepInterface::class);

        $event = new BeforeHandleStep('data', ['entity'], new Step(new StepKey('key'), $step));

        $this->listener->handle($event);
    }

    public function testHandleStepIsNotValidatable(): void
    {
        $this->validator->expects($this->never())
            ->method('validate');

        $step = $this->createStub(StepInterface::class);

        $event = new BeforeHandleStep(['data' => 'test'], ['entity'], new Step(new StepKey('key'), $step));

        $this->listener->handle($event);
    }
}
