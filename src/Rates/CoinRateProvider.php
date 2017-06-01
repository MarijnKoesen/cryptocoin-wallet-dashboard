<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Rates;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use Money\Currency;

interface CoinRateProvider
{
    public function getRate(Coin $coin, Currency $currency): float;
}
