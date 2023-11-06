<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Tests\PageObject\PaginaListagemSeries;

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
        self::$driver->get('http://localhost:8000');
        $paginaListagem = new PaginaListagemSeries(self::$driver);

        // Assert
        self::assertSame('Séries', $paginaListagem->titulo());
    }
    
    public static function tearDownAfterClass(): void
    {
        self::$driver->close();
    }
}
