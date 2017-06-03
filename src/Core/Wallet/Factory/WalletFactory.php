<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Factory;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\CoinRateProvider;
use Money\Currency;
use Money\Money;

final class WalletFactory
{
    /**
     * @var CoinRateProvider
     */
    private $coinRateProvider;

    public function __construct(CoinRateProvider $coinRateProvider)
    {
        $this->coinRateProvider = $coinRateProvider;
    }

    public function getWallet(array $walletEntries): Wallet
    {
        $entries = [];

        foreach ($walletEntries as $coinName => $entry) {
            $coin = new Coin($coinName);

            $entries[] = $this->createEntry($entry, $coin);
        }

        return new Wallet(...$entries);
    }

    private function createEntry(array $entryData, Coin $coin): Entry
    {
        $boughtFor = explode(' ', $entryData['boughtFor']);
        $initialValue = new Money($boughtFor[0] * 100, new Currency($boughtFor[1]));

        $rate = $this->coinRateProvider->getRate($coin, $initialValue->getCurrency());
        $currentValue = new Money((int)($entryData['amount'] * $rate * 100), $initialValue->getCurrency());

        return new Entry($coin, $entryData['amount'], $initialValue, $currentValue);
    }
}
