<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Printer;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Symfony\Component\Console\Output\OutputInterface;

interface ConsolePrinter
{
    public function printWallet(Wallet $wallet, OutputInterface $output);
}
