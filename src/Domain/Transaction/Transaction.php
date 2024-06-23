<?php

declare(strict_types=1);

namespace App\Domain\Transaction;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

final readonly class Transaction
{
    public function __construct(public string $bin, public float|int $amount, public string $currency)
    {
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata
            ->addPropertyConstraints(
                'bin',
                [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            )
            ->addPropertyConstraints(
                'amount',
                [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ]
            )
            ->addPropertyConstraints(
                'currency',
                [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            );
    }
}
