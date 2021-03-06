<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Core\Wallet;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use Money\Money;
use PHPUnit\Framework\TestCase;

class EntryTest extends TestCase
{
    public function testConstructor()
    {
        $entry = new Entry(Coin::RIPPLE(), 10, Money::EUR(20), Money::EUR(21));

        $this->assertEquals(Coin::RIPPLE(), $entry->getCoin());
        $this->assertSame(10.0, $entry->getAmount());
        $this->assertEquals(Money::EUR(20.0), $entry->getInitialValue());
        $this->assertEquals(Money::EUR(21.0), $entry->getCurrentValue());

        $this->assertEquals(Money::EUR(1), $entry->getProfit());
        $this->assertEquals(5, $entry->getProfitPercentage());
    }
}
