<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Rates\CoinRateProvider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider\Fixer;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class FixerTest extends TestCase
{
    /**
     * @test
     */
    public function fetchingRate()
    {
        $apiResult = '{"base":"EUR","date":"2017-05-31","rates":{"GBP":0.87365,"USD":1.1221}}';
        $client = $this->getGuzzleMock($apiResult);
        $provider = new Fixer($client);

        $rate = $provider->getRate(new Currency('EUR'), new Currency('USD'));
        self::assertEquals(1.1221, $rate, '', 0.0000001);
    }

    /**
     * @test
     */
    public function anExceptionIsThrownForNotFoundCurrency()
    {
        $apiResult = '{"base":"EUR","date":"2017-05-31","rates":{"GBP":0.87365,"USD":1.1221}}';
        $client = $this->getGuzzleMock($apiResult);
        $provider = new Fixer($client);

        self::expectException(RuntimeException::class);
        $provider->getRate(new Currency('EUR'), new Currency('CAD'));
    }

    protected function getGuzzleMock(string $result): ClientInterface
    {
        $guzzleMock = new MockHandler([
            new Response(200, [], $result)
        ]);

        $handler = HandlerStack::create($guzzleMock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }
}
