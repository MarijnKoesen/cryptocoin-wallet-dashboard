<?php

declare(strict_types=1);

use MarijnKoesen\CryptocoinWalletDashboard\Core\Coin;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Entry;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Printer\CompactConsolePrinter;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Money\Money;
use Money\MoneyFormatter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\Output;

final class CompactConsolePrinterTest extends TestCase
{
    /**
     * @test
     */
    public function output()
    {
        $output = new TestOutput();

        $wallet = new Wallet(
            new Entry(Coin::RIPPLE(), 10, Money::USD(1), Money::USD(2)),
            new Entry(Coin::BITCOIN(), 20, Money::EUR(2), Money::EUR(1))
        );

        $moneyFormatter = new MoneyFormatterStub();

        $printer = new CompactConsolePrinter($moneyFormatter);
        $printer->printWallet($wallet, $output);

        // We're using a file because of the colors, it's a bit more readable this way
        self::assertEquals(file_get_contents(__DIR__ . '/expected_output.txt'), $output->output);
    }
}

final class MoneyFormatterStub implements MoneyFormatter
{
    public function format(Money $money)
    {
        return $money->getAmount() . '@' . $money->getCurrency()->getCode();
    }
}

final class TestOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message.($newline ? "\n" : '');
    }
}
