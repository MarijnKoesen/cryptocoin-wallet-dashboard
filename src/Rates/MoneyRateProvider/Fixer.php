<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;

use GuzzleHttp\ClientInterface;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;
use Money\Currency;
use RuntimeException;

final class Fixer implements MoneyRateProvider
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    public function __construct(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getRate(Currency $from, Currency $to): float
    {
        $fromString = strtoupper($from->getCode());
        $toString = strtoupper($to->getCode());

        $apiEndPoint = 'http://api.fixer.io/latest?base=' . $fromString . '&symbols=' . $toString;

        $apiResponse = $this->guzzle->request('GET', $apiEndPoint)->getBody();
        $data = json_decode($apiResponse, true);

        if (!isset($data['rates'][$toString])) {
            throw new RuntimeException('Rate could not be fetched');
        }

        return $data['rates'][$toString];
    }
}
