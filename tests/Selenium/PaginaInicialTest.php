<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PaginaInicialTest extends TestCase
{
    public function testPaginaInicialNaoLogadaDeveSerListagemDeSeries()
    {
        // Arange
        $serverUrl = 'http://localhost:4444';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());

        // Act
        $driver->navigate()->to('http://localhost:8000');

        // Assert
        $h1Locator = WebDriverBy::tagName('h1');
        $textoH1= $driver
            ->findElement($h1Locator)
            ->getText();
        self::assertStringContainsString('Séries', $textoH1);
    }
}
