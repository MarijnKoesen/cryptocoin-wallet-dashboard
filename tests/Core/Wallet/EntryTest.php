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
        $entry = new Entry(Coin::RIPPLE(), 10, Money::EUR(22), Money::EUR(23));

        $this->assertEquals(Coin::RIPPLE(), $entry->getCoin());
        $this->assertSame(10.0, $entry->getAmount());
        $this->assertEquals(Money::EUR(22.0), $entry->getInitialValue());
        $this->assertEquals(Money::EUR(23.0), $entry->getCurrentValue());
    }
}
