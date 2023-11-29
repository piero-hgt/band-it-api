<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Validator;

use Shared\Domain\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

final class Validator implements ValidatorInterface
{
    public function __construct(private SymfonyValidatorInterface $validator)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validate(object $data, array $context = []): void
    {
        if (null !== $validationGroups = $context['groups'] ?? null) {
            if (\is_callable($validationGroups)) {
                $validationGroups = $validationGroups($data);
            }

            if (!$validationGroups instanceof GroupSequence) {
                $validationGroups = (array) $validationGroups;
            }
        }

        $violations = new ConstraintViolationList();

        $violations->addAll($this->validator->validate($data, null, $validationGroups));
        if (0 !== \count($violations)) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, implode("\n", array_map(static fn ($e) => $e->getMessage(), iterator_to_array($violations))), new ValidationFailedException($data, $violations));
        }
    }
}
