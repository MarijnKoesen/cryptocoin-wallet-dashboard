<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;

use GuzzleHttp\ClientInterface;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;
use Money\Currency;
use RuntimeException;

final class Fixer implements MoneyRateProvider
{
    /**
     * @var array
     */
    private $apiConfig;

    /**
     * @var ClientInterface
     */
    private $guzzle;

    public function __construct(array $apiConfig, ClientInterface $guzzle)
    {
        $this->apiConfig = $apiConfig;
        $this->guzzle = $guzzle;
    }

    public function getRate(Currency $from, Currency $to): float
    {
        $fromString = strtoupper($from->getCode());
        $toString = strtoupper($to->getCode());

        $apiEndPoint = $this->apiConfig['fixer']['url'];
        $apiEndPoint = str_replace('{api_key}', $this->apiConfig['fixer']['key'], $apiEndPoint);
        $apiEndPoint = str_replace('{from}', $fromString, $apiEndPoint);
        $apiEndPoint = str_replace('{to}', $toString, $apiEndPoint);

        $apiResponse = $this->guzzle->request('GET', $apiEndPoint)->getBody();
        $data = json_decode($apiResponse, true);

        if (!isset($data['rates'][$toString])) {
            throw new RuntimeException('Rate could not be fetched');
        }

        return $data['rates'][$toString];
    }
}
