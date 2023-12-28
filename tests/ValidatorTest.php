<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Tests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator as LaravelValidator;
use Illuminate\Support\MessageBag;
use Lexal\LaravelStepValidator\Exception\ValidatorException;
use Lexal\LaravelStepValidator\RulesDefinition;
use Lexal\LaravelStepValidator\Validator;
use Lexal\LaravelStepValidator\ValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    private MockObject $validatorFactory;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validatorFactory = $this->createMock(ValidationFactory::class);

        $this->validator = new Validator($this->validatorFactory);
    }

    public function testValidate(): void
    {
        $validator = $this->createStub(LaravelValidator::class);

        $validator->method('fails')
            ->willReturn(false);

        $this->validatorFactory->expects($this->once())
            ->method('make')
            ->with(['data' => 'test'], ['data' => 'required'], [], [])
            ->willReturn($validator);

        $this->validator->validate(['data' => 'test'], new RulesDefinition(['data' => 'required']));
    }

    public function testValidateWithException(): void
    {
        /** @phpstan-ignore-next-line */
        $this->expectExceptionObject(new ValidatorException(['data' => ['required message']]));

        $validator = $this->createStub(LaravelValidator::class);

        $validator->method('fails')
            ->willReturn(true);

        $validator->method('errors')
            ->willReturn(new MessageBag(['data' => 'required message']));

        $this->validatorFactory->expects($this->once())
            ->method('make')
            ->with(['data' => 'test'], ['data' => 'required'], ['data' => 'test message'], [])
            ->willReturn($validator);

        $this->validator->validate(
            ['data' => 'test'],
            new RulesDefinition(['data' => 'required'], ['data' => 'test message']),
        );
    }
}
