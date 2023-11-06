<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase
{
    private WebDriver $driver;

    protected function setUp(): void
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        $this->driver->get('http://localhost:8000/adicionar-serie');

        $this->driver->findElement(WebDriverBy::id('email'))
            ->sendKeys('cesar@exemplo.com');
        $this->driver->findElement(WebDriverBy::id('password'))
            ->sendKeys('123')
            ->submit();
        sleep(1);
        $this->driver->get('http://localhost:8000/adicionar-serie');
    }


    public function testCadastrarNovaSeriesDeveRedirecionarParaLista()
    {


        sleep(1);
        // Act
        $inputNome = $this->driver->findElement(WebDriverBy::id('nome'));
        $inputGenero = $this->driver->findElement(WebDriverBy::id('genre'));
        $inputTemporadas = $this->driver->findElement(WebDriverBy::id('qtd_temporadas'));
        $inputEpisodios = $this->driver->findElement(WebDriverBy::id('ep_por_temporada'));

        $inputNome->sendKeys('Teste');
        $selectGenero = new WebDriverSelect($inputGenero);
        $selectGenero->selectByValue('acao');
        $inputTemporadas->sendKeys('1');
        $inputEpisodios->sendKeys('1');
        $inputEpisodios->submit();
        sleep(1);   

        // Assert
        self::assertSame('http://localhost:8000/series', $this->driver->getCurrentURL());
        $elementoSucesso = $this->driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'));
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim($elementoSucesso->getText())
        );
    }
    
    protected function tearDown(): void
    {
        $this->driver->close();
    }
}
