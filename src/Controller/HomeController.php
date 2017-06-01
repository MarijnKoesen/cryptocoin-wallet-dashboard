<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Controller;

use MarijnKoesen\CryptocoinWalletDashboard\Core\Wallet\Wallet;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class HomeController
{
    /**
     * @var array
     */
    private $wallet;

    /**
     * @var EngineInterface
     */
    private $templateEngine;

    public function __construct(Wallet $wallet, Twig_Environment $templateEngine)
    {
        $this->wallet = $wallet;
        $this->templateEngine = $templateEngine;
    }

    public function get(Request $request)
    {
        return new Response($this->templateEngine->render('home.html.twig', ['wallet' => $this->wallet]));
    }
}
