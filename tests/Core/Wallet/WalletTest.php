<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Core\Wallet;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Money\Money;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testWalletConstructor()
    {
        $entries = [
            new Entry(Coin::RIPPLE(), 10, Money::USD(1), Money::USD(2)),
            new Entry(Coin::BITCOIN(), 20, Money::EUR(2), Money::EUR(2))
        ];

        $wallet = new Wallet(...$entries);

        $this->assertEquals($entries, $wallet->getEntries());
    }
}
