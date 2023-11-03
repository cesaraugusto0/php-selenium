<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use PHPUnit\Framework\TestCase;

class ResistroTest extends TestCase
{
    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        $driver->get('http://localhost:8000/novo-usuario');


        // Act
        $inputNome = $driver->findElement(WebDriverBy::id('name'));
        $inputEmail = $driver->findElement(WebDriverBy::id('email'));
        $inputSenha = $driver->findElement(WebDriverBy::id('password'));

        $inputNome->sendKeys('Nome Teste');
        $inputEmail->sendKeys(md5(time()).'email@example.com');
        $inputSenha->sendKeys('123');

        $inputSenha->submit();

        // Assert
        self::assertSame('http://localhost:8000/series', $driver->getCurrentURL());
        self::assertinstanceOf(
            RemoteWebElement::class,
            $driver->findElement(WebDriverBy::linkText('Sair'))
        );
    }

}
