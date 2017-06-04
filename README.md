# Cryptocoin Wallet Dasboard

[![Latest Version](https://img.shields.io/github/release/MarijnKoesen/cryptocoin-wallet-dashboard.svg?style=flat-square)](https://github.com/MarijnKoesen/cryptocoin-wallet-dashboard/releases)
[![Build Status](https://img.shields.io/travis/MarijnKoesen/cryptocoin-wallet-dashboard.svg?style=flat-square)](https://travis-ci.org/MarijnKoesen/cryptocoin-wallet-dashboard)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/MarijnKoesen/cryptocoin-wallet-dashboard.svg?style=flat-square)](https://scrutinizer-ci.com/g/MarijnKoesen/cryptocoin-wallet-dashboard)
[![Quality Score](https://img.shields.io/scrutinizer/g/MarijnKoesen/cryptocoin-wallet-dashboard.svg?style=flat-square)](https://scrutinizer-ci.com/g/MarijnKoesen/cryptocoin-wallet-dashboard)


![Console Dashboard](/resources/console.png?raw=true)
![Web Dashboard](/resources/web.png?raw=true)


## Install

To start using the dashboard you need to clone the project and setup your wallet
based on the cryptocoins that you own.

```bash
$ git clone https://github.com/MarijnKoesen/cryptocoin-wallet-dashboard.git
$ cd cryptocoin-wallet-dashboard.git
$ cp .env.dist .env
$ cp etc/packages/wallet.yaml.dist etc/packages/wallet.yaml
```

## Configuration

Use your favourite editor to define your wallet in `etc/packages/wallet.yaml`:

```yaml
parameters:
    wallet:
        # Supported coins: BCN, DASH, ETH, LTC, STRAT, WAVES, XBT, XEM, XMR, XRP
        BCN:
            amount: 100
            boughtFor: '5 USD'
        DASH:
            amount: 10
            boughtFor: '10 EUR'
        ETH:
            amount: 50
            boughtFor: '2.50 EUR'
```


## Web Dashboard

You can use the built-in webserver, or deploy it somewhere.

```bash
$ make serve
$ open http://localhost:8000
```

## Console Dashboard

You can use the built-in webserver, or deploy it somewhere.

```bash
$ bin/print-wallet
BCN: $2.50 => $2.67 | 0.0025 => 0.0027 (+$0.17 = +6.8%)
DASH: €100.00 => €126.83 | 100 => 126.83 (+€26.83 = +26.83%)
ETH: €30.00 => €1,042.59 | 6 => 208.518 (+€1,012.59 = +3375.3%)
```
