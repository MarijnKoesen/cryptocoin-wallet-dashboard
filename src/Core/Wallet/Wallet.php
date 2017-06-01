<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet;

class Wallet
{
    /**
     * @var Entry[]
     */
    private $entries = [];

    public function __construct(Entry ...$entries)
    {
        $this->entries = $entries;
    }

    /**
     * @return Entry[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }
}
