<?php

namespace Tests\PageObject;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

class PaginaListagemSeries
{
    private WebDriver $driver;

    public function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function visita(): self
    {
        $this->driver->get('http://localhost:8000/series');

        return $this;
    }

    public function titulo():string
    {
        return $this->driver
            ->findElement(WebDriverBy::tagName('h1'))
            ->getText();
        }
}
