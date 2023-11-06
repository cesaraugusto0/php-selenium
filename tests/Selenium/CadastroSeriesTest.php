<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;
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

    protected function setUp(): void
    {
        self::$driver->get('http://localhost:8000/adicionar-serie');
        sleep(1);
    }

    public function testCadastrarNovaSeriesDeveRedirecionarParaLista()
    {
        // Act
        $inputNome = self::$driver->findElement(WebDriverBy::id('nome'));
        $inputGenero = self::$driver->findElement(WebDriverBy::id('genre'));
        $inputTemporadas = self::$driver->findElement(WebDriverBy::id('qtd_temporadas'));
        $inputEpisodios = self::$driver->findElement(WebDriverBy::id('ep_por_temporada'));

        $inputNome->sendKeys('Teste');
        $selectGenero = new WebDriverSelect($inputGenero);
        $selectGenero->selectByValue('acao');
        $inputTemporadas->sendKeys('1');
        $inputEpisodios->sendKeys('1');
        $inputEpisodios->submit();
        sleep(1);   

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
