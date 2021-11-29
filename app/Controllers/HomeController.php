<?php

namespace Test\Controllers;

class HomeController
{
    public function index($response)
    {
        return $response->setBody('home');
    }

}