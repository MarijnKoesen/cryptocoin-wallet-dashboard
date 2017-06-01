<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Rates;

use Money\Currency;

interface MoneyRateProvider
{
    public function getRate(Currency $from, Currency $to): float;
}
