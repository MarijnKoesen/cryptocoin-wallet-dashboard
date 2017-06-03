<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Console;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Printer\ConsolePrinter;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PrintWalletCommand extends Command
{
    /**
     * @var null
     */
    private $name;

    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var ConsolePrinter
     */
    private $compactPrinter;

    public function __construct($name = null, Wallet $wallet, ConsolePrinter $compactPrinter)
    {
        parent::__construct($name);

        $this->name = $name;
        $this->wallet = $wallet;
        $this->compactPrinter = $compactPrinter;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('coin-result:print-wallet')
            ->setDescription('Print your wallet with the current value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->compactPrinter->printWallet($this->wallet, $output);
    }
}
