<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Printer;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Money\MoneyFormatter;
use Symfony\Component\Console\Output\OutputInterface;

final class CompactConsolePrinter implements ConsolePrinter
{
    /**
     * @var MoneyFormatter
     */
    private $moneyFormatter;

    public function __construct(MoneyFormatter $moneyFormatter)
    {
        $this->moneyFormatter = $moneyFormatter;
    }

    public function printWallet(Wallet $wallet, OutputInterface $output)
    {
        foreach ($wallet->getEntries() as $entry) {
            $result = $entry->getProfit();
            $resultPercentage = round($entry->getProfitPercentage(), 2);

            $output->write(
                $this->makeBlue($entry->getCoin()->getValue()) . ': ' .
                $this->moneyFormatter->format($entry->getInitialValue()) . ' => ' .
                $this->moneyFormatter->format($entry->getCurrentValue()));

            $output->write(
                ' | ' .
                round($entry->getInitialValue()->getAmount() / 100 / $entry->getAmount(), 4) . ' => ' .
                round($entry->getCurrentValue()->getAmount() / 100 / $entry->getAmount(), 4));

            $resultString = ((int)$result->getAmount() > 0)
                ? $this->makeGreen('+' . $this->moneyFormatter->format($result))
                : $this->makeRed($this->moneyFormatter->format($result));

            $resultPercentageString = ($result->getAmount() > 0)
                ? $this->makeGreen('+' . $resultPercentage . '%')
                : $this->makeRed($resultPercentage . '%');

            $output->write(' (' . $resultString . ' = ' . $resultPercentageString . ")\n");
        }
    }

    private function color(string $string, string $color)
    {
        return $color . $string . "\033[0m";
    }

    private function makeBlue(string $string)
    {
        return $this->color($string, "\033[34m");
    }

    private function makeGreen(string $string)
    {
        return $this->color($string, "\033[32m");
    }

    private function makeRed(string $string)
    {
        return $this->color($string, "\033[31m");
    }
}
