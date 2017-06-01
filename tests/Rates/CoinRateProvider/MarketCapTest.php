<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Rates\CoinRateProvider;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\CoinRateProvider\MarketCap;
use MarijnKoesen\CryptocoinWalletDashboard\Rates\MoneyRateProvider;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class MarketCapTest extends TestCase
{
    private const RATE = 0.00253917;

    public function testNoConversion()
    {
        $coin = Coin::BITCOIN();
        $moneyRateProvider = $this->getMoneyRateProviderThatIsNotCalled();

        $coinRateProvider = $this->getCoinRateProvider($coin, $moneyRateProvider);
        $rate = $coinRateProvider->getRate(Coin::BITCOIN(), new Currency('USD'));

        self::assertEquals(self::RATE, $rate, '', 0.0000001);
    }

    public function testConversionWithConversion()
    {
        $coin = Coin::BITCOIN();
        $currencyFrom = new Currency('USD');
        $currencyTo = new Currency('EUR');
        $moneyRateProvider = $this->getMoneyRateProvider($currencyFrom, $currencyTo, 1.25);

        $coinRateProvider = $this->getCoinRateProvider($coin, $moneyRateProvider);
        $rate = $coinRateProvider->getRate(Coin::BITCOIN(), $currencyTo);

        self::assertEquals(self::RATE * 1.25, $rate, '', 0.0000001);
    }

    /**
     * @test
     */
    public function anExceptionIsThrownForAnUnkonwnCoin()
    {
        $provider = new MarketCap([], $this->getMoneyRateProviderThatIsNotCalled(), new Client());

        $this->expectException(RuntimeException::class);
        $provider->getRate(Coin::BITCOIN(), new Currency('CAD'));
    }

    protected function getGuzzleMock(string $result): Client
    {
        $guzzleMock = new MockHandler([
            new Response(200, [], $result)
        ]);

        $handler = HandlerStack::create($guzzleMock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    protected function getMoneyRateProviderThatIsNotCalled(): MoneyRateProvider
    {
        $mock = $this->createMock(MoneyRateProvider::class);
        $mock->expects($this->never())->method('getRate');

        return $mock;
    }

    protected function getMoneyRateProvider(Currency $from, Currency $to, float $rate): MoneyRateProvider
    {
        $mock = $this->createMock(MoneyRateProvider::class);
        $mock
            ->method('getRate')
            ->with($from, $to)
            ->willReturn($rate);

        return $mock;
    }

    protected function getCoinRateProvider(Coin $coin, MoneyRateProvider $moneyRateProvider): MarketCap
    {
        $apiResult = '[{
            "id": "bytecoin-bcn",
            "name": "Bytecoin",
            "symbol": "BCN",
            "rank": "10",
            "price_usd": "' . self::RATE . '",
            "price_btc": "0.00000107",
            "24h_volume_usd": "5451780.0",
            "market_cap_usd": "464576615.0",
            "available_supply": "182963966514",
            "total_supply": "182963966514",
            "percent_change_1h": "4.35",
            "percent_change_24h": "17.2",
            "percent_change_7d": "-9.2",
            "last_updated": "1496294652"
        }]';

        $client = $this->getGuzzleMock($apiResult);

        $provider = new MarketCap(
            [
                $coin->getValue() => [
                    'tickerApi' => 'http://the.api'
                ]
            ],
            $moneyRateProvider,
            $client
        );
        return $provider;
    }
}
