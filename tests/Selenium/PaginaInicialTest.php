<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PaginaInicialTest extends TestCase
{
    private static WebDriver $driver;

    public static function setUpBeforeClass(): void
    {
        // Arange
        $serverUrl = 'http://localhost:4444';
        self::$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
    }

    public function testPaginaInicialNaoLogadaDeveSerListagemDeSeries()
    {
        // Act
        self::$driver->navigate()->to('http://localhost:8000');

        // Assert
        $h1Locator = WebDriverBy::tagName('h1');
        $textoH1= self::$driver
            ->findElement($h1Locator)
            ->getText();
        self::assertStringContainsString('Séries', $textoH1);
    }
    
    public static function tearDownAfterClass(): void
    {
        self::$driver->close();
    }
}
