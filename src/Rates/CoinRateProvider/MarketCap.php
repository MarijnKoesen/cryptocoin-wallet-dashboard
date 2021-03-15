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
    private $apiConfig;

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

    public function __construct(array $apiConfig, array $config, MoneyRateProvider $eurUsdRateProvider, ClientInterface $guzzle)
    {
        $this->apiConfig = $apiConfig;
        $this->config = $config;
        $this->guzzle = $guzzle;
        $this->eurUsdRateProvider = $eurUsdRateProvider;
    }

    public function getRate(Coin $coin, Currency $currency): float
    {
        if (!isset($this->config[$coin->getValue()])) {
            throw new RuntimeException('Coin ' . $coin->getValue() . ' is not supported');
        }

        $apiResponse = $this->guzzle->request('GET', $this->apiConfig['coinmarketcap']['url'], [
            'headers' => ['X-CMC_PRO_API_KEY' => $this->apiConfig['coinmarketcap']['key']]
        ])->getBody();
        $data = json_decode($apiResponse, true);
        $data = $data['data'];
        $data = current(array_filter($data, function ($item) use ($coin) {
            return $item['symbol'] == $coin;
        }));
        if ($data === false) {
            throw new RuntimeException('Symbol ' . $coin->getValue() . ' not found in output');
        }

        $rateInUsd = $data['quote']['USD']['price'];

        if (strtoupper($currency->getCode()) == 'USD') {
            return $rateInUsd;
        }

        return $rateInUsd * $this->eurUsdRateProvider->getRate(new Currency('USD'), $currency);
    }
}
