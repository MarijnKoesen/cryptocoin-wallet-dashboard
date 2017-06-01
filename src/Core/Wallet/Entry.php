<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use Money\Money;

class Entry
{
    /**
     * @var Coin
     */
    private $coin;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var Money
     */
    private $initialValue;

    /**
     * @var Money
     */
    private $currentValue;

    public function __construct(Coin $coin, float $amount, Money $initialValue, Money $currentValue)
    {
        $this->coin = $coin;
        $this->amount = $amount;
        $this->initialValue = $initialValue;
        $this->currentValue = $currentValue;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCoin(): Coin
    {
        return $this->coin;
    }

    public function getInitialValue(): Money
    {
        return $this->initialValue;
    }

    public function getCurrentValue(): Money
    {
        return $this->currentValue;
    }
}
