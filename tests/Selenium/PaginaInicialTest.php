<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
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
        self::assertStringContainsString('Séries', $driver->getPageSource());
    }
}
