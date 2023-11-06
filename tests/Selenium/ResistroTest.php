<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PHPUnit\Framework\TestCase;

class ResistroTest extends TestCase
{
    private WebDriver $driver;

    protected function setUp(): void
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        $this->driver->get('http://localhost:8000/novo-usuario');        
    }

    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Act
        $inputNome = $this->driver->findElement(WebDriverBy::id('name'));
        $inputEmail = $this->driver->findElement(WebDriverBy::id('email'));
        $inputSenha = $this->driver->findElement(WebDriverBy::id('password'));

        $inputNome->sendKeys('Nome Teste');
        $inputEmail->sendKeys(md5(time()).'email@example.com');
        $inputSenha->sendKeys('123');
        $inputSenha->submit();

        $this->driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::linkText('Sair'))
        );

        // Assert
        self::assertSame('http://localhost:8000/series', $this->driver->getCurrentURL());
        self::assertinstanceOf(
            RemoteWebElement::class,
            $this->driver->findElement(WebDriverBy::linkText('Sair'))
        );
    }

    protected function tearDown(): void
    {
        $this->driver->close();
    }

}
