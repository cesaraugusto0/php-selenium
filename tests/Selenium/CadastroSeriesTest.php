<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Tests\PageObject\PaginaCadastroSeries;
use Tests\PageObject\PaginaLogin;

class CadastroSeriesTest extends TestCase
{
    private static WebDriver $driver;

    public static function setUpBeforeClass(): void
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        self::$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        
        $paginaLogin = new PaginaLogin(self::$driver);
        $paginaLogin->realizaLoginCom('cesar@exemplo.com', '123');
    }

    public function testCadastrarNovaSeriesDeveRedirecionarParaLista()
    {
        // Act
        $paginaCadastro = new PaginaCadastroSeries(self::$driver);
        $paginaCadastro->preencheNome('Teste')
            ->selecionaGenero('acao')
            ->comTemporadas(1)
            ->comEpisodios(1)
            ->enviarFormulario();

        // Assert
        self::assertSame('http://localhost:8000/series', self::$driver->getCurrentURL());
        $elementoSucesso = self::$driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'));
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim($elementoSucesso->getText())
        );
    }

    public static function tearDownAfterClass(): void
    {
        self::$driver->close();
    }
}
