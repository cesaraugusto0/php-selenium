<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase
{
    public function testCadastrarNovaSeriesDeveRedirecionarParaLista()
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        $driver->get('http://localhost:8000/adicionar-serie');

        $driver->findElement(WebDriverBy::id('email'))
            ->sendKeys('cesar@exemplo.com');
        $driver->findElement(WebDriverBy::id('password'))
            ->sendKeys('123')
            ->submit();
        sleep(1);
        $driver->get('http://localhost:8000/adicionar-serie');

        sleep(1);
        // Act
        $inputNome = $driver->findElement(WebDriverBy::id('nome'));
        $inputGenero = $driver->findElement(WebDriverBy::id('genre'));
        $inputTemporadas = $driver->findElement(WebDriverBy::id('qtd_temporadas'));
        $inputEpisodios = $driver->findElement(WebDriverBy::id('ep_por_temporada'));

        $inputNome->sendKeys('Teste');
        $selectGenero = new WebDriverSelect($inputGenero);
        $selectGenero->selectByValue('acao');
        $inputTemporadas->sendKeys('1');
        $inputEpisodios->sendKeys('1');
        $inputEpisodios->submit();
        sleep(1);   

        // Assert
        self::assertSame('http://localhost:8000/series', $driver->getCurrentURL());
        $elementoSucesso = $driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'));
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim($elementoSucesso->getText())
        );
        $driver->close();
    }
}
