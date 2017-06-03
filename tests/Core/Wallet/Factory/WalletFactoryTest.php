<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Core\Wallet\Factory;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Factory\WalletFactory;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\CoinRateProvider;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class WalletFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function walletConstruction()
    {
        $coinRateProvider = $this->getCoinRateProvider([
            Coin::BITCOIN => 2000,
            Coin::BYTECOIN => 0.025
        ]);

        $factory = new WalletFactory($coinRateProvider);
        $wallet = $factory->getWallet([
            Coin::BITCOIN => [
                'amount' => 100,
                'boughtFor' => '1000 EUR'
            ],
            Coin::BYTECOIN => [
                'amount' => 50,
                'boughtFor' => '4.50 EUR'
            ],
        ]);

        // Money uses cents, so we need to multiply the money amount with 100
        $this->assertEquals(
            [
                new Entry(
                    Coin::BITCOIN(),
                    100,
                    new Money(1000 * 100, new Currency('EUR')),
                    new Money(100 * 2000 * 100, new Currency('EUR'))
                ),
                new Entry(
                    Coin::BYTECOIN(),
                    50,
                    new Money(4.50 * 100, new Currency('EUR')),
                    new Money(50 * 0.025 * 100, new Currency('EUR'))
                )
            ],
            $wallet->getEntries()
        );
    }

    public function getCoinRateProvider(array $rates)
    {
        return new class($rates) implements CoinRateProvider
        {
            private $rates;

            public function __construct(array $rates)
            {
                $this->rates = $rates;
            }

            public function getRate(Coin $coin, Currency $currency): float
            {
                return $this->rates[$coin->getValue()];
            }
        };
    }
}
