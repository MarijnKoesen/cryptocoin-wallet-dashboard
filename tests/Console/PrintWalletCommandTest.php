<?php

declare(strict_types=1);

use MarijnKoesen\CryptocoinWalletDashboard\Console\PrintWalletCommand;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Printer\ConsolePrinter;
use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class PrintWalletCommandTest extends TestCase
{
    public function testA()
    {
        $input = new ArrayInput([]);
        $output = new BufferedOutput();
        $wallet = new Wallet();

        $printer = $this->createMock(ConsolePrinter::class);
        $printer->expects($this->once())->method('printWallet')->with($wallet, $output);

        $command = new PrintWalletCommand(null, $wallet, $printer);
        $command->run($input, $output);

        self::assertEquals('coin-result:print-wallet', $command->getName());
    }
}
