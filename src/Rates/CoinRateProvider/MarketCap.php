<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Rates\CoinRateProvider;

use GuzzleHttp\ClientInterface;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\CoinRateProvider;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;
use Money\Currency;
use RuntimeException;

final class MarketCap implements CoinRateProvider
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ClientInterface
     */
    private $guzzle;
    /**
     * @var MoneyRateProvider
     */
    private $eurUsdRateProvider;

    public function __construct(array $config, MoneyRateProvider $eurUsdRateProvider, ClientInterface $guzzle)
    {
        $this->config = $config;
        $this->guzzle = $guzzle;
        $this->eurUsdRateProvider = $eurUsdRateProvider;
    }

    public function getRate(Coin $coin, Currency $currency): float
    {
        if (!isset($this->config[$coin->getValue()])) {
            throw new RuntimeException('Coin ' . $coin->getValue() . ' is not supported');
        }

        $apiResponse = $this->guzzle->request('GET', $this->config[$coin->getValue()]['tickerApi'])->getBody();
        $data = json_decode($apiResponse, true)[0];

        $rateInUsd = $data['price_usd'];

        if (strtoupper($currency->getCode()) == 'USD') {
            return $rateInUsd;
        }

        return $rateInUsd * $this->eurUsdRateProvider->getRate(new Currency('USD'), $currency);
    }
}
