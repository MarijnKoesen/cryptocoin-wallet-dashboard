<?php

declare(strict_types=1);

namespace MarijnKoesen\CryptocoinWalletDashboard\Core;

use MyCLabs\Enum\Enum;

/**
 * @method static Coin BITCOIN()
 * @method static Coin BYTECOIN()
 * @method static Coin RIPPLE()
 */
final class Coin extends Enum
{
    const BITCOIN = 'XBT';
    const BYTECOIN = 'BCN';
    const DASH = 'DASH';
    const ETHEREUM = 'ETH';
    const LITECOIN = 'LTC';
    const MONERO = 'XMR';
    const NEM = 'XEM';
    const RIPPLE = 'XRP';
    const STRATIS = 'STRAT';
    const WAVES = 'WAVES';
}
