<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Tests\Core;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoinTest extends WebTestCase
{
    /**
     * @test
     */
    public function testConstructor()
    {
        $kernel = self::createKernel();
        $kernel->boot();

        $supportedCoins = $kernel->getContainer()->getParameter('coins');

        foreach ($supportedCoins as $coinName => $details) {
            $coin = new Coin($coinName);

            self::assertSame($coinName, $coin->getValue());
        }
    }
}
