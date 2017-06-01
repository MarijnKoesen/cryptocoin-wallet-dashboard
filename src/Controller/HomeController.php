<?php

namespace MarijnKoesen\CryptocoinWalletDashboard\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function get(Request $request)
    {
        return new Response('Hello World!');
    }
}
