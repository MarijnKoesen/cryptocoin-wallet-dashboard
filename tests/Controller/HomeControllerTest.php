<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Controller;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    public function testDashboard()
    {
        $client = static::createClient();
        $this->mockWallet($client);

        $client->request('GET', '/');

        self::assertContains('$1.50', $client->getResponse()->getContent());
        self::assertContains('€0.02', $client->getResponse()->getContent());
    }

    protected function mockWallet(Client $client): void
    {
        $container = $client->getContainer();

        $wallet = new Wallet(
            new Entry(Coin::RIPPLE(), 10, Money::USD(150), Money::USD(2)),
            new Entry(Coin::BITCOIN(), 20, Money::EUR(2), Money::EUR(2))
        );

        $container->set(Wallet::class, $wallet);
    }
}
