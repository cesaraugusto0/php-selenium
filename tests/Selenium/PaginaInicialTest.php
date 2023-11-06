<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PaginaInicialTest extends TestCase
{
    private WebDriver $driver;

    protected function setUp(): void
    {
        // Arange
        $serverUrl = 'http://localhost:4444';
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
    }

    public function testPaginaInicialNaoLogadaDeveSerListagemDeSeries()
    {
        // Act
        $this->driver->navigate()->to('http://localhost:8000');

        // Assert
        $h1Locator = WebDriverBy::tagName('h1');
        $textoH1= $this->driver
            ->findElement($h1Locator)
            ->getText();
        self::assertStringContainsString('Séries', $textoH1);
    }
    
    protected function tearDown(): void
    {
        $this->driver->close();
    }
}
