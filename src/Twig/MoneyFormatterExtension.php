<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Twig;

use Money\Money;
use Money\MoneyFormatter;
use Twig_Extension;
use Twig_SimpleFilter;

final class MoneyFormatterExtension extends Twig_Extension
{
    /**
     * @var MoneyFormatter
     */
    private $formatter;

    public function __construct(MoneyFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('formatMoney', array($this, 'formatMoney')),
        );
    }

    public function formatMoney(Money $money)
    {
        return $this->formatter->format($money);
    }
}
