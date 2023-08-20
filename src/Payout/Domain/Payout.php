<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain;

use Payouts\Payout\Domain\Event\PayoutCreatedEvent;
use Payouts\Payout\Domain\ValueObject\PayoutAmount;
use Payouts\Payout\Domain\ValueObject\PayoutBankAccountNumber;
use Payouts\Payout\Domain\ValueObject\PayoutCreatedAt;
use Payouts\Payout\Domain\ValueObject\PayoutEmail;
use Payouts\Payout\Domain\ValueObject\PayoutName;
use Payouts\Payout\Domain\ValueObject\PayoutStatus;
use Payouts\Payout\Domain\ValueObject\PayoutUuid;
use Payouts\Shared\Domain\Aggregate\AggregateRoot;
use Payouts\Shared\Domain\Utils;

final class Payout extends AggregateRoot
{
    public function __construct(
        private readonly PayoutUuid $uuid,
        private readonly PayoutName $name,
        private readonly PayoutEmail $email,
        private readonly PayoutBankAccountNumber $bankAccountNumber,
        private readonly PayoutAmount $amount,
        private readonly PayoutStatus $status,
        private readonly PayoutCreatedAt $createdAt,
    ) {
    }

    public static function create(
        PayoutUuid $uuid,
        PayoutName $name,
        PayoutEmail $email,
        PayoutBankAccountNumber $bankAccountNumber,
        PayoutAmount $amount,
        PayoutStatus $status,
    ): self {
        $payout = new self($uuid, $name, $email, $bankAccountNumber, $amount, $status, new PayoutCreatedAt());

        $payout->record(new PayoutCreatedEvent($payout));

        return $payout;
    }

    public function uuid(): PayoutUuid
    {
        return $this->uuid;
    }

    public function name(): PayoutName
    {
        return $this->name;
    }

    public function email(): PayoutEmail
    {
        return $this->email;
    }

    public function bankAccountNumber(): PayoutBankAccountNumber
    {
        return $this->bankAccountNumber;
    }

    public function amount(): PayoutAmount
    {
        return $this->amount;
    }

    public function status(): PayoutStatus
    {
        return $this->status;
    }

    public function createdAt(): PayoutCreatedAt
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid()->value(),
            'name' => $this->name()->value(),
            'email' => $this->email()->value(),
            'bankAccountNumber' => $this->bankAccountNumber()->value(),
            'amount' => $this->amount()->value(),
            'status' => $this->status->value(),
            'createdAt' => Utils::dateToString($this->createdAt()->date()),
        ];
    }

    public static function fromArray(array $parameters): self
    {
        return new self(
            new PayoutUuid($parameters['uuid']),
            new PayoutName($parameters['name']),
            new PayoutEmail($parameters['email']),
            new PayoutBankAccountNumber($parameters['bankAccountNumber']),
            new PayoutAmount($parameters['amount']),
            new PayoutStatus($parameters['status']),
            new PayoutCreatedAt(Utils::stringToDate($parameters['createdAt']))
        );
    }
}
